<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    public function Orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->as("order_product")
            ->withPivot('quantity');
        //->withTimestamps();
    }
}
