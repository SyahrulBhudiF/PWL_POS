<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
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
    function store(Request $request) {
        Kategori::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);
        return redirect('/kategori');
    }

    /**
     * Return to edit page
     */
    function edit($id) {
        $kategori =Kategori::find($id);
        return view('kategori.edit', ['data' => $kategori]);
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
}
