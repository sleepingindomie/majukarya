<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';
    protected $primaryKey = 'id_vendor';

    protected $fillable = [
        'kode_vendor',
        'nama_vendor',
    ];

    /**
     * Get the items for this vendor
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'vendor_items', 'id_vendor', 'id_item')
                    ->withPivot('harga_sebelum', 'harga_sekarang')
                    ->withTimestamps();
    }

    /**
     * Get the orders for this vendor
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_vendor', 'id_vendor');
    }

    /**
     * Get the vendor items
     */
    public function vendorItems()
    {
        return $this->hasMany(VendorItem::class, 'id_vendor', 'id_vendor');
    }
}
