<?php

namespace App\Http\Controllers;

use App\DataTables\LevelDataTable;
use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Models\Level;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LevelController extends Controller
{

    function index(LevelDataTable $dataTable)
    {
        return $dataTable->render('level.index');
    }

    function create()
    {
        return view('level.create');
    }

    function store(StoreLevelRequest $request)
    {
        $validated = $request->safe()->only(['level_kode', 'level_nama']);

        Level::create($validated);
        return redirect('/level');
    }

    function edit($id)
    {
        return view('level.edit', ['data' => Level::find($id)]);
    }

    function update(UpdateLevelRequest $request, $id)
    {
        $validated = $request->safe()->only(['level_kode', 'level_nama']);
        Level::find($id)->update($validated);

        return redirect('/level');
    }

    function destroy($id)
    {
        Level::find($id)->delete();

        return redirect('/level');
    }
}
