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


    public function getSumAttribute(){
        return str_replace(['.00',',','$'], "", $this->price);
    }
}
