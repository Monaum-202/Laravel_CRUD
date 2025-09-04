<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory,Blameable;

    protected $fillable = [
        'product_id',
        'reviewer_name',
        'comment',
        'rating',
    ];

    // Each Review belongs to one Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
