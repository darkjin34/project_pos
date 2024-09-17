<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductSize;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'image_at', 'category'];

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

}
