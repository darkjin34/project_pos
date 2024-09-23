<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_statuses extends Model
{
    protected $fillable = ['order_id', 'status'];

    use HasFactory;
}
