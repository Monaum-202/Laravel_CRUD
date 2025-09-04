<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory,Blameable;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
