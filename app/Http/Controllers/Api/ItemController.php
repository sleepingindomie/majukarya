<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of items.
     */
    public function index()
    {
        $items = Item::all();

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $items
        ]);
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_item' => 'required|string|unique:items,kode_item',
            'nama_item' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $item = Item::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Item berhasil ditambahkan',
            'data' => $item
        ], 201);
    }

    /**
     * Display the specified item.
     */
    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $item
        ]);
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_item' => 'required|string|unique:items,kode_item,' . $id . ',id_item',
            'nama_item' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $item->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Item berhasil diupdate',
            'data' => $item
        ]);
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Item berhasil dihapus'
        ]);
    }
}
