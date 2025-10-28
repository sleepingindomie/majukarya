<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'tgl_order',
        'no_order',
        'id_vendor',
        'id_item',
    ];

    /**
     * Get the vendor for this order
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }

    /**
     * Get the item for this order
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}
