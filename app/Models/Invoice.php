<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];



    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'net_price', 'iva', 'withholding_tax','discount','description');
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function state()
    {
        return $this->belongsTo(StatusInvoce::class,'status_invoces_id');
    }

    public function advances(){
        return $this->hasMany(AdvancePayments::class);
    }

    public function getPartialSumAttribute()
    {
            return $this->advances->sum('sum');
    }
    public function getTotalAttribute()
    {
        return $this->products->reduce(function ($ml, $product) {
            $price = $this->format($product->pivot->net_price);
            $iva = $this->format($product->pivot->iva);
            $current = $product->pivot ? ($price * (1 + ($iva / 100))) * $product->pivot->quantity : 0;
            return $ml + $current;
        });
    }
    public function getPendingAttribute()
    {
        return $this->total - $this->partialSum;
    }

    private function format($value)
    {
        return str_replace(['.00', ',', '$'], "", $value);
    }
}
