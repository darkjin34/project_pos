<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order_items;

class Orders extends Model
{
    protected $fillable = ['order_number', 'customer_name', 'status', 'total_price'];

    use HasFactory;
    public function orderItems()
    {
        return $this->hasMany(Order_items::class, 'order_id');
    }
}
