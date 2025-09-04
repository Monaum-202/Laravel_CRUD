<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory,Blameable;

    protected $table = 'product_details';

    protected $fillable = [
        'product_id',
        'specifications',
        'manufacturer',
        'warranty',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
