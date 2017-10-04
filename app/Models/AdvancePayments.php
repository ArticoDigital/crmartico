<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvancePayments extends Model
{
    protected $guarded = [];

    public function getSumAttribute(){
        return str_replace(['.00',',','$'], "", $this->price);
    }
}
