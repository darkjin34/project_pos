<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductSize;

class Order_items extends Model
{
    protected $fillable = ['order_id', 'product_size_id', 'quantity', 'subtotal'];

    use HasFactory;

    
    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }
}
