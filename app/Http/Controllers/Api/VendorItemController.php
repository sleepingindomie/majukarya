<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VendorItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorItemController extends Controller
{
    /**
     * Display a listing of vendor items.
     */
    public function index()
    {
        $vendorItems = VendorItem::with(['vendor', 'item'])->get();

        $data = $vendorItems->map(function ($vendorItem) {
            return [
                'id_vendor_item' => $vendorItem->id_vendor_item,
                'id_vendor' => $vendorItem->id_vendor,
                'vendor' => [
                    'kode_vendor' => $vendorItem->vendor->kode_vendor,
                    'nama_vendor' => $vendorItem->vendor->nama_vendor,
                ],
                'id_item' => $vendorItem->id_item,
                'item' => [
                    'kode_item' => $vendorItem->item->kode_item,
                    'nama_item' => $vendorItem->item->nama_item,
                ],
                'harga_sebelum' => (float) $vendorItem->harga_sebelum,
                'harga_sekarang' => (float) $vendorItem->harga_sekarang,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created vendor item in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_vendor' => 'required|exists:vendors,id_vendor',
            'id_item' => 'required|exists:items,id_item',
            'harga_sebelum' => 'required|numeric|min:0',
            'harga_sekarang' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if vendor-item combination already exists
        $exists = VendorItem::where('id_vendor', $request->id_vendor)
                            ->where('id_item', $request->id_item)
                            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Vendor item combination already exists. Please update the existing one.',
            ], 422);
        }

        $vendorItem = VendorItem::create($request->all());
        $vendorItem->load(['vendor', 'item']);

        return response()->json([
            'status' => true,
            'message' => 'Vendor item berhasil ditambahkan',
            'data' => [
                'id_vendor_item' => $vendorItem->id_vendor_item,
                'id_vendor' => $vendorItem->id_vendor,
                'vendor' => [
                    'kode_vendor' => $vendorItem->vendor->kode_vendor,
                    'nama_vendor' => $vendorItem->vendor->nama_vendor,
                ],
                'id_item' => $vendorItem->id_item,
                'item' => [
                    'kode_item' => $vendorItem->item->kode_item,
                    'nama_item' => $vendorItem->item->nama_item,
                ],
                'harga_sebelum' => (float) $vendorItem->harga_sebelum,
                'harga_sekarang' => (float) $vendorItem->harga_sekarang,
            ]
        ], 201);
    }

    /**
     * Display the specified vendor item.
     */
    public function show($id)
    {
        $vendorItem = VendorItem::with(['vendor', 'item'])->find($id);

        if (!$vendorItem) {
            return response()->json([
                'status' => false,
                'message' => 'Vendor item tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => [
                'id_vendor_item' => $vendorItem->id_vendor_item,
                'id_vendor' => $vendorItem->id_vendor,
                'vendor' => [
                    'kode_vendor' => $vendorItem->vendor->kode_vendor,
                    'nama_vendor' => $vendorItem->vendor->nama_vendor,
                ],
                'id_item' => $vendorItem->id_item,
                'item' => [
                    'kode_item' => $vendorItem->item->kode_item,
                    'nama_item' => $vendorItem->item->nama_item,
                ],
                'harga_sebelum' => (float) $vendorItem->harga_sebelum,
                'harga_sekarang' => (float) $vendorItem->harga_sekarang,
            ]
        ]);
    }

    /**
     * Update the specified vendor item in storage.
     */
    public function update(Request $request, $id)
    {
        $vendorItem = VendorItem::find($id);

        if (!$vendorItem) {
            return response()->json([
                'status' => false,
                'message' => 'Vendor item tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_vendor' => 'required|exists:vendors,id_vendor',
            'id_item' => 'required|exists:items,id_item',
            'harga_sebelum' => 'required|numeric|min:0',
            'harga_sekarang' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if vendor-item combination already exists (excluding current record)
        $exists = VendorItem::where('id_vendor', $request->id_vendor)
                            ->where('id_item', $request->id_item)
                            ->where('id_vendor_item', '!=', $id)
                            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Vendor item combination already exists.',
            ], 422);
        }

        $vendorItem->update($request->all());
        $vendorItem->load(['vendor', 'item']);

        return response()->json([
            'status' => true,
            'message' => 'Vendor item berhasil diupdate',
            'data' => [
                'id_vendor_item' => $vendorItem->id_vendor_item,
                'id_vendor' => $vendorItem->id_vendor,
                'vendor' => [
                    'kode_vendor' => $vendorItem->vendor->kode_vendor,
                    'nama_vendor' => $vendorItem->vendor->nama_vendor,
                ],
                'id_item' => $vendorItem->id_item,
                'item' => [
                    'kode_item' => $vendorItem->item->kode_item,
                    'nama_item' => $vendorItem->item->nama_item,
                ],
                'harga_sebelum' => (float) $vendorItem->harga_sebelum,
                'harga_sekarang' => (float) $vendorItem->harga_sekarang,
            ]
        ]);
    }

    /**
     * Remove the specified vendor item from storage.
     */
    public function destroy($id)
    {
        $vendorItem = VendorItem::find($id);

        if (!$vendorItem) {
            return response()->json([
                'status' => false,
                'message' => 'Vendor item tidak ditemukan'
            ], 404);
        }

        $vendorItem->delete();

        return response()->json([
            'status' => true,
            'message' => 'Vendor item berhasil dihapus'
        ]);
    }
}
