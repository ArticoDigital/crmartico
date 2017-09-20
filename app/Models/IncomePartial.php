<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomePartial extends Model
{
    protected $guarded = [];
    public function getSumAttribute(){
        return str_replace(['.00',',','$'], "", $this->price);
    }
}
