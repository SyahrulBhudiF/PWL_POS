<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Stok;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransaksiPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar Penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        $users = User::select(['user_id', 'nama'])->get();

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'users' => $users, 'activeMenu' => $activeMenu]);
    }

    /**
     * Display list table of items.
     */
    public function list(Request $request)
    {
        $penjualan = Penjualan::with('user');

        if ($request->user_id) $penjualan->where('user_id', $request->user_id);

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('total', function ($penjualan) {
                $totalHarga = PenjualanDetail::where('penjualan_id', $penjualan->penjualan_id)->sum('harga');
                return $totalHarga;
            })
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm mx-2">Detail</a> ';
                $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '" class="btn btn-warning btn-sm mx-2">Edit</a> ';
                $btn .= '<form class="d-inline-block mx-2" method="POST" action="' .
                    url('/penjualan/' . $penjualan->penjualan_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->editColumn('penjualan_id', '')
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Penjualan',
            'list' => ['Home', 'Penjualan', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Penjualan baru'
        ];

        $barangs = Barang::all();
        $users = User::all();
        $penjualan = Penjualan::orderBy('penjualan_tanggal', 'desc')->first();

        $numericPart = substr($penjualan->penjualan_kode, 4);
        $numericPart++;
        $newPenjualanCode = "SELL" . $numericPart;

        $activeMenu = 'penjualan';

        return view('penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barangs' => $barangs, 'kode' => $newPenjualanCode, 'users' => $users, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'penjualan_kode' => 'required|unique:t_penjualan,penjualan_kode',
            'pembeli' => 'required',
            'penjualan_tanggal' => 'required',
            'barang_id.*' => 'required',
            'jumlah.*' => 'required',
        ]);

//        start open database transaction
        DB::beginTransaction();
        try {

            $data = $request->except('barang_id', 'jumlah', '_token');
//            insert with return id
            $penjualan = Penjualan::insertGetId($data);

            // Loop through details
            foreach ($request->barang_id as $key => $barang_id) {
//                get stok
                $stok = Stok::where('barang_id', $barang_id)->firstOrFail();

//                check if stok is < jumlah return error
                if ($stok->stok_jumlah < $request->jumlah[$key]) return redirect()->back()->with('error', 'Stok tidak cukup');

//               reduce stok with jumlah
                $stok->stok_jumlah -= $request->jumlah[$key];
                $stok->save();

                $barang = Barang::find($barang_id);

                // Create PenjualanDetail for each detail
                PenjualanDetail::insert([
                    'penjualan_id' => $penjualan,
                    'barang_id' => $barang_id,
                    'jumlah' => $request->jumlah[$key],
                    'harga' => ($barang->harga_jual * $request->jumlah[$key]),
                ]);
            }

//            commit or insert to database
            DB::commit();

            return redirect('/penjualan')->with('success', 'Penjualan berhasil disimpan.');
        } catch (\Exception $e) {
//            rollback data if the program fail, that useable for delete remains data so that the data will not save to database
            DB::rollback();

            return redirect()->back()->with('error', 'Penjualan gagal disimpan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $details = PenjualanDetail::with('barang', 'penjualan')->where('penjualan_id', $id)->get();

        $breadcrumb = (object)[
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Penjualan'
        ];

        /**
         * Set active menu
         */
        $activeMenu = 'penjualan';

        $totals = 0;
        foreach ($details as $detail) {
            $totals += $detail->harga;
        }

        return view('penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'details' => $details, 'total' => $totals, 'activeMenu' => $activeMenu]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penjualan = Penjualan::find($id);

        $barangs = Barang::all();

        $users = User::all();

        $details = PenjualanDetail::where('penjualan_id', $id)->get();

        $breadcrumb = (object)[
            'title' => 'Edit Penjualan',
            'list' => ['Home', 'Penjualan', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'details' => $details, 'barangs' => $barangs, 'users' => $users, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penjualanValidated = $request->only('user_id', 'pembeli', 'penjualan_tanggal');

        Penjualan::where('penjualan_id', $id)->update($penjualanValidated);

        for ($i = 0; $i < $request->count; $i++) {
            $detailPenjualanValidated = [
                'barang_id' => $request->barang_id[$i],
                'jumlah' => $request->jumlah[$i]
            ];

            PenjualanDetail::where('detail_id', $request->id[$i])->update($detailPenjualanValidated);
        }

        return redirect('/penjualan')->with('success', 'Data Penjualan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = Penjualan::find($id);

        if (!$check) return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');

        try {
            PenjualanDetail::where('penjualan_id', $check->penjualan_id)->delete();

            Penjualan::destroy($id);

            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');

        } catch (QueryException $e) {
            return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
