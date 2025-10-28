<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Report 1: Item yang disediakan masing-masing vendor
     */
    public function vendorItems()
    {
        $vendors = Vendor::with(['vendorItems.item'])->get();

        $data = $vendors->map(function ($vendor) {
            return [
                'id_vendor' => $vendor->id_vendor,
                'kode_vendor' => $vendor->kode_vendor,
                'nama_vendor' => $vendor->nama_vendor,
                'item' => $vendor->vendorItems->map(function ($vendorItem) {
                    return [
                        'id_item' => $vendorItem->item->id_item,
                        'kode_item' => $vendorItem->item->kode_item,
                        'nama_item' => $vendorItem->item->nama_item,
                    ];
                })->values()->toArray()
            ];
        })->values()->toArray();

        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data
        ]);
    }

    /**
     * Report 2: Rank vendor dengan transaksi paling banyak
     */
    public function vendorRanking()
    {
        $vendors = Vendor::select('vendors.id_vendor', 'vendors.kode_vendor', 'vendors.nama_vendor')
            ->selectRaw('COUNT(orders.id_order) as jumlah_transaksi')
            ->leftJoin('orders', 'vendors.id_vendor', '=', 'orders.id_vendor')
            ->groupBy('vendors.id_vendor', 'vendors.kode_vendor', 'vendors.nama_vendor')
            ->orderBy('jumlah_transaksi', 'desc')
            ->get();

        $data = $vendors->map(function ($vendor) {
            return [
                'id_vendor' => $vendor->id_vendor,
                'kode_vendor' => $vendor->kode_vendor,
                'nama_vendor' => $vendor->nama_vendor,
                'jumlah_transaksi' => (float) $vendor->jumlah_transaksi
            ];
        })->values()->toArray();

        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data
        ]);
    }

    /**
     * Report 3: Rate up/down harga dari item yang disediakan
     */
    public function priceRate()
    {
        $vendors = Vendor::with(['vendorItems.item'])->get();

        $data = $vendors->map(function ($vendor) {
            return [
                'id_vendor' => $vendor->id_vendor,
                'kode_vendor' => $vendor->kode_vendor,
                'nama_vendor' => $vendor->nama_vendor,
                'item' => $vendor->vendorItems->map(function ($vendorItem) {
                    $hargaSebelum = (float) $vendorItem->harga_sebelum;
                    $hargaSekarang = (float) $vendorItem->harga_sekarang;
                    $selisih = $hargaSekarang - $hargaSebelum;

                    // Determine status
                    if ($selisih < 0) {
                        $status = 'down';
                    } elseif ($selisih > 0) {
                        $status = 'up';
                    } else {
                        $status = 'stable';
                    }

                    // Calculate rate
                    $rate = 0;
                    if ($hargaSebelum != 0) {
                        $rate = abs($selisih / $hargaSebelum * 100);
                    }

                    return [
                        'id_item' => $vendorItem->item->id_item,
                        'kode_item' => $vendorItem->item->kode_item,
                        'nama_item' => $vendorItem->item->nama_item,
                        'harga_sebelum' => $hargaSebelum,
                        'harga_sekarang' => $hargaSekarang,
                        'selisih' => abs($selisih),
                        'rate' => round($rate, 2),
                        'status' => $status
                    ];
                })->values()->toArray()
            ];
        })->values()->toArray();

        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data
        ]);
    }
}
