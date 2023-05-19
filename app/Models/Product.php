<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function hasStock(int $quantity)
    {
        return $this->stock >= $quantity;
    }

    public function orders() :BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity')->as('detail');
    }

    public function decrementStock(int $quantity)
    {
        $this->decrement('stock', $quantity);
    }

}
