<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePenjualanDetailRequest;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanDetailRequest;
use App\Http\Requests\UpdatePenjualanRequest;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Stok;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class TransaksiPenjualan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Penjualan::all();
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(StorePenjualanDetailRequest $penjualanDetailRequests, StorePenjualanRequest $penjualanRequest): JsonResponse
    {
        /**
         * store penjualan data in database
         */
        $penjualan = Penjualan::create($penjualanRequest->input());

        $details = [];
        $stokChanges = [];
        for ($i = 0; $i < count($penjualanDetailRequests->input('barang_id.*')); $i++) {
            /**
             * store penjualan details data in database
             */
            $penjualanDetail = PenjualanDetail::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'harga' => $penjualanDetailRequests->input('harga' . $i),
                'barang_id' => $penjualanDetailRequests->input('barang_id.' . $i),
                'jumlah' => $penjualanDetailRequests->input('jumlah.' . $i),
            ]);

            /**
             * reduce valid stok_jumlah data in stok database that we retrieve to make penjualan detail in column jumlah above
             */
            $stok = Stok::with('barang')->find($penjualanDetail->barang_id);
            $oldStok = $stok->stok_jumlah;
            $usedStok = $penjualanDetail->jumlah;
            $stok->stok_jumlah -= $usedStok;
            $stok->save();
            $stokChanges['stok change ' . $i + 1] = [
                'Barang id' => $stok->barang_id,
                'Barang Nama' => $stok->barang->barang_nama,
                'Start Stok' => $oldStok,
                'Used Stok' => $usedStok,
                'End Stok' => $stok->stok_jumlah
            ];

            $penjualanDetail['Barang Nama'] = $stok->barang->barang_nama;
            $details['detail ' . $i + 1] = $penjualanDetail;
        }

        return response()->json([
            'success' => true,
            'Transaksi' => $penjualan,
            'Details Transaksi' => $details,
            'Barang Stok Changes' => $stokChanges
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PenjualanDetail $transaksi): JsonResponse
    {
        $penjualan = Penjualan::find($transaksi->penjualan_id);
        $penjualanDetail = PenjualanDetail::with('barang')->where('penjualan_id', '=', $transaksi->penjualan_id)->get();
        return response()->json([
            'success' => true,
            'Transaksi' => $penjualan,
            'Detail Transaksi' => $penjualanDetail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenjualanDetailRequest $penjualanDetailRequests, UpdatePenjualanRequest $penjualanRequest, string $id): JsonResponse
    {
        $penjualanData = Penjualan::find($id);
        $penjualanData->update($penjualanRequest->all());

        $details = [];
        $stokChanges = [];
        for ($i = 0; $i < count($penjualanDetailRequests->input('detail_id.*')); $i++) {
            $penjualanDetailData = PenjualanDetail::find($penjualanDetailRequests->input('detail_id.' . $i));

            $penjualanDetailData->barang_id = $penjualanDetailRequests->input('barang_id.' . $i);
            $penjualanDetailData->harga = $penjualanDetailRequests->input('harga' . $i);
            $penjualanDetailData->jumlah = $penjualanDetailRequests->input('jumlah.' . $i);
            $penjualanDetailData->save();

            /**
             * reduce valid stok_jumlah data in stok database that we retrieve to make penjualan detail in column jumlah above
             */
            $stok = Stok::with('barang')->find($penjualanDetailData->barang_id);
            $oldStok = $stok->stok_jumlah;
            $usedStok = $penjualanDetailData->jumlah;
            $stok->stok_jumlah -= $usedStok;
            $stok->save();
            $stokChanges['stok change ' . $i + 1] = [
                'Barang id' => $stok->barang_id,
                'Barang Nama' => $stok->barang->barang_nama,
                'Start Stok' => $oldStok,
                'Used Stok' => $usedStok,
                'End Stok' => $stok->stok_jumlah
            ];

            $penjualanDetailData['Barang Nama'] = $stok->barang->barang_nama;
            $details['detail ' . $i + 1] = $penjualanDetailData;
        }

        return response()->json([
            'success' => true,
            'Transaksi' => $penjualanData,
            'Details Transaksi' => $details,
            'Barang Stok Changes' => $stokChanges
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            Penjualan::find($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Transaksi penjualan success deleted'
            ]);
        } catch (QueryException $qe) {
            return response()->json([
                'success' => false,
                'errors' => $qe->getMessage(),
            ], 422);
        }
    }
}
