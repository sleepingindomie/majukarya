<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorItem extends Model
{
    protected $table = 'vendor_items';
    protected $primaryKey = 'id_vendor_item';

    protected $fillable = [
        'id_vendor',
        'id_item',
        'harga_sebelum',
        'harga_sekarang',
    ];

    /**
     * Get the vendor for this vendor item
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }

    /**
     * Get the item for this vendor item
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}
