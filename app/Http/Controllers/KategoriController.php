<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }

    function create() {
        return view('kategori.create');
    }

    function store(Request $request) {
        Kategori::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);
        return redirect('/kategori');
    }
}
