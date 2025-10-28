<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with(['vendor', 'item'])->get();

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $orders
        ]);
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tgl_order' => 'required|string',
            'no_order' => 'required|string|unique:orders,no_order',
            'id_vendor' => 'required|exists:vendors,id_vendor',
            'id_item' => 'required|exists:items,id_item',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::create($request->all());
        $order->load(['vendor', 'item']);

        return response()->json([
            'status' => true,
            'message' => 'Order berhasil ditambahkan',
            'data' => $order
        ], 201);
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['vendor', 'item'])->find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $order
        ]);
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'tgl_order' => 'required|string',
            'no_order' => 'required|string|unique:orders,no_order,' . $id . ',id_order',
            'id_vendor' => 'required|exists:vendors,id_vendor',
            'id_item' => 'required|exists:items,id_item',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $order->update($request->all());
        $order->load(['vendor', 'item']);

        return response()->json([
            'status' => true,
            'message' => 'Order berhasil diupdate',
            'data' => $order
        ]);
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        $order->delete();

        return response()->json([
            'status' => true,
            'message' => 'Order berhasil dihapus'
        ]);
    }
}
