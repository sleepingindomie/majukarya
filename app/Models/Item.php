<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id_item';

    protected $fillable = [
        'kode_item',
        'nama_item',
    ];

    /**
     * Get the vendors for this item
     */
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_items', 'id_item', 'id_vendor')
                    ->withPivot('harga_sebelum', 'harga_sekarang')
                    ->withTimestamps();
    }

    /**
     * Get the orders for this item
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_item', 'id_item');
    }

    /**
     * Get the vendor items
     */
    public function vendorItems()
    {
        return $this->hasMany(VendorItem::class, 'id_item', 'id_item');
    }
}
