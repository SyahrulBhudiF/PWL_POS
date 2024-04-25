<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Stok;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object)[
            'title' => 'Daftar Stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok';

        $barangs = Barang::select(['barang_id', 'barang_nama'])->get();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barangs' => $barangs, 'activeMenu' => $activeMenu]);
    }

    /**
     * Display list table of items.
     */
    function list(Request $request)
    {
        $stok = Stok::with('barang', 'user');

//        filter
        if ($request->barang_id) $stok->where('barang_id', $request->barang_id);

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm mx-2">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm mx-2">Edit</a> ';
                $btn .= '<form class="d-inline-block mx-2" method="POST" action="' .
                    url('/stok/' . $stok->stok_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->editColumn('stok_id', '')
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Stok'
        ];

        $users = User::select(['user_id', 'nama'])->get();
        $barangs = Barang::select(['barang_id', 'barang_nama'])->get();

        $activeMenu = 'stok';

        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barangs, 'user' => $users, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'barang_id' => 'required',
            'user_id' => 'required',
            'stok_jumlah' => 'required',
            'stok_tanggal' => 'required',
        ]);

        $stok = Stok::where('barang_id', $request->barang_id)->first();

        if ($stok) {
            $stok->stok_jumlah += $request->stok_jumlah;
            $stok->save();

        } else {
            Stok::insert($data);
        }

        return redirect('/stok')->with('success', 'Data barang berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stok = Stok::with('barang', 'user')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Stok'
        ];

        $activeMenu = 'stok';

        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stok = Stok::find($id);

        $users = User::select(['user_id', 'nama'])->get();

        $barangs = Barang::select(['barang_id', 'barang_nama'])->get();

        $breadcrumb = (object)[
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Stok'
        ];

        $activeMenu = 'stok';

        return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'users' => $users, 'barangs' => $barangs, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'barang_id' => 'required',
            'user_id' => 'required',
            'stok_jumlah' => 'required',
            'stok_tanggal' => 'required',
        ]);

        Stok::where('stok_id', $id)->update($data);

        return redirect('/stok')->with('success', 'Data Stok berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = Stok::find($id);

        if (!$check) return redirect('/stok')->with('error', 'Data stok tidak ditemukan');

        try {
            Stok::destroy($id);

            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');

        } catch (QueryException $e) {
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
