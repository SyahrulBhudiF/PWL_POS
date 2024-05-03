<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Level::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(Level::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level): Level|Collection|array|null
    {
        return Level::find($level);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level): Level|Collection|array|null
    {
        $level->update($request->all());
        return Level::find($level);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level): JsonResponse
    {
        $level->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus'
        ]);
    }
}
