<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class ProductSize extends Model
{
    use HasFactory;
    // Define the inverse relationship
    public function products()
    {
        return $this->belongsTo(Products::class);
    }
}
