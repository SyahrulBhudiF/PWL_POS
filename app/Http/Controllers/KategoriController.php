<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Http\Requests\StorePostRequest;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Shows all kategori
     */
    function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }

    /**
     * Return Create kategori page
     */
    function create() {
        return view('kategori.create');
    }

    /**
     * Create a new row from input req form
     */
    function store(StorePostRequest $request) {
        $validated = $request->validated();

        $validated = $request->safe()->only(['kodeKategori', 'namaKategori']);
        $validated = $request->safe()->except(['kodeKategori', 'namaKategori']);

        Kategori::create([
            'kategori_kode' => $validated['kodeKategori'],
            'kategori_nama' => $validated['namaKategori'],
        ]);
        return redirect('/kategori');
    }

    /**
     * Return to edit page
     */
    function edit($id) {
        return view('kategori.edit', ['data' => Kategori::find($id)]);
    }

    /**
     * Update kategori data
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;

        $kategori->save();
        return redirect('/kategori');
    }

    function destroy($id) {
        Kategori::find($id)->delete();

        return redirect('/kategori');
    }
}
