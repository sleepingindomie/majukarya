<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    /**
     * Display a listing of vendors.
     */
    public function index()
    {
        $vendors = Vendor::all();

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $vendors
        ]);
    }

    /**
     * Store a newly created vendor in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_vendor' => 'required|string|unique:vendors,kode_vendor',
            'nama_vendor' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $vendor = Vendor::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Vendor berhasil ditambahkan',
            'data' => $vendor
        ], 201);
    }

    /**
     * Display the specified vendor.
     */
    public function show($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'status' => false,
                'message' => 'Vendor tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $vendor
        ]);
    }

    /**
     * Update the specified vendor in storage.
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'status' => false,
                'message' => 'Vendor tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_vendor' => 'required|string|unique:vendors,kode_vendor,' . $id . ',id_vendor',
            'nama_vendor' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $vendor->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Vendor berhasil diupdate',
            'data' => $vendor
        ]);
    }

    /**
     * Remove the specified vendor from storage.
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'status' => false,
                'message' => 'Vendor tidak ditemukan'
            ], 404);
        }

        $vendor->delete();

        return response()->json([
            'status' => true,
            'message' => 'Vendor berhasil dihapus'
        ]);
    }
}
