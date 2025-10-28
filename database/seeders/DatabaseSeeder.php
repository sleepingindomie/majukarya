<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Item;
use App\Models\Order;
use App\Models\VendorItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create Vendors
        $vendor1 = Vendor::create([
            'kode_vendor' => 'V01',
            'nama_vendor' => 'Vendor 1',
        ]);

        $vendor2 = Vendor::create([
            'kode_vendor' => 'V02',
            'nama_vendor' => 'Vendor 2',
        ]);

        $vendor3 = Vendor::create([
            'kode_vendor' => 'V03',
            'nama_vendor' => 'Vendor 3',
        ]);

        // Create Items
        $item1 = Item::create([
            'kode_item' => 'IT01',
            'nama_item' => 'Item 1',
        ]);

        $item2 = Item::create([
            'kode_item' => 'IT02',
            'nama_item' => 'Item 2',
        ]);

        $item3 = Item::create([
            'kode_item' => 'IT03',
            'nama_item' => 'Item 3',
        ]);

        // Create Vendor Items (for price rate report)
        VendorItem::create([
            'id_vendor' => $vendor1->id_vendor,
            'id_item' => $item1->id_item,
            'harga_sebelum' => 15000.00,
            'harga_sekarang' => 10000.00,
        ]);

        VendorItem::create([
            'id_vendor' => $vendor1->id_vendor,
            'id_item' => $item2->id_item,
            'harga_sebelum' => 25000.00,
            'harga_sekarang' => 27000.00,
        ]);

        VendorItem::create([
            'id_vendor' => $vendor2->id_vendor,
            'id_item' => $item3->id_item,
            'harga_sebelum' => 15000.00,
            'harga_sekarang' => 15000.00,
        ]);

        // Create Orders (for vendor ranking report)
        // Vendor 1 - 30 orders
        for ($i = 1; $i <= 30; $i++) {
            Order::create([
                'tgl_order' => '2025-10-28',
                'no_order' => 'ORD-V1-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'id_vendor' => $vendor1->id_vendor,
                'id_item' => $item1->id_item,
            ]);
        }

        // Vendor 2 - 25 orders
        for ($i = 1; $i <= 25; $i++) {
            Order::create([
                'tgl_order' => '2025-10-28',
                'no_order' => 'ORD-V2-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'id_vendor' => $vendor2->id_vendor,
                'id_item' => $item3->id_item,
            ]);
        }

        // Vendor 3 - 20 orders
        for ($i = 1; $i <= 20; $i++) {
            Order::create([
                'tgl_order' => '2025-10-28',
                'no_order' => 'ORD-V3-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'id_vendor' => $vendor3->id_vendor,
                'id_item' => $item2->id_item,
            ]);
        }
    }
}
