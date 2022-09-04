<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilter($query)
    {
        $status = request('status');
        $min_price = (int)request('min_price');
        $max_price = (int)request('max_price');
        $order = request('order');


        if ($order) {
            $query->orderBy('title', $order);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($min_price && $max_price){
            return $query->whereBetween('price', [$min_price, $max_price]);
        }

        if ($min_price) {
            $query->where('price',  '>=', $min_price);
        }

        if ($max_price) {
            $query->where('price', '<=', $max_price);
        }
        // dd($query->toSql());
        // dd($query->get());
        return $query;
    }
}
