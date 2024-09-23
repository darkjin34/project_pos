<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = ['order_id', 'amount', 'payment_method', 'payment_status'];

    use HasFactory;
}
