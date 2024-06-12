<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {

        return $this->belongsTo(Category::class);
    }

    public function getProfitPercentAttribute()
    {

        $profit = $this->sale_price - $this->purchase_price;
        $profit_percent = $profit * 100 / $this->purchase_price;
        return number_format($profit_percent, 2);

    }

    public function orders()
    {

        return $this->belongsToMany(Order::class, 'product_order');
    }

}
