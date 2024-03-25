<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
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
    function create()
    {
        return view('kategori.create');
    }

    /**
     * Create a new row from input req form
     */
    function store(StorePostRequest $request)
    {
        $validated = $request->safe()->only(['kategori_kode', 'kategori_nama']);

        Kategori::create($validated);
        return redirect('/kategori');
    }

    /**
     * Return to edit page
     */
    function edit($id)
    {
        return view('kategori.edit', ['data' => Kategori::find($id)]);
    }

    /**
     * Update kategori data
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $validated = $request->safe()->only(['kategori_kode', 'kategori_nama']);
        Kategori::find($id)->update($validated);

        return redirect('/kategori');
    }

    function destroy($id)
    {
        Kategori::find($id)->delete();

        return redirect('/kategori');
    }
}
