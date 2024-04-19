<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar barang',
            'list' => ['Home', 'barang']
        ];

        $page = (object)[
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';

        $kategoris = Kategori::select(['kategori_id', 'kategori_nama'])->get();

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategoris, 'activeMenu' => $activeMenu]);
    }

    /**
     * Display list table of items.
     */
    function list(Request $request)
    {
        $barang = Barang::select(['barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual'])->with('kategori');

//        filter
        if ($request->kategori_id) $barang->where('kategori_id', $request->kategori_id);

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm mx-2">Detail</a> ';
                $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm mx-2">Edit</a> ';
                $btn .= '<form class="d-inline-block mx-2" method="POST" action="' .
                    url('/barang/' . $barang->barang_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->editColumn('barang_id', '')
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah barang baru'
        ];

        $kategori = Kategori::all();
        $activeMenu = 'barang';

        $barang = Barang::orderBy('barang_id', 'desc')->first();

//        dd($barang->barang_kode);

        $numericPart = substr($barang->barang_kode, 3);
        $numericPart++;
        $newCode = "BRG" . $numericPart;

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'kode' => $newCode, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'kategori_id' => 'required|integer',
        ]);

        Barang::insert($data);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang = Barang::with('kategori')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail page barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::find($id);
        $kategori = Kategori::all();

        $breadcrumb = (object)[
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit barang'
        ];

        $activeMenu = 'barang';

        return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'barang_kode' => 'string|min:3',
            'barang_nama' => 'string|max:100',
            'harga_beli' => 'min:3',
            'harga_jual' => 'min:3',
        ]);

        Barang::where('barang_id', $id)->update($data);

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = Barang::find($id);

        if (!$check) return redirect('/barang')->with('error', 'Data barang tidak ditemukan');

        try {
            Barang::destroy($id);

            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');

        } catch (QueryException $e) {
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
