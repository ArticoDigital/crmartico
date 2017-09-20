<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Income extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getDocumentAttribute($pdf)
    {
        if (!$pdf || starts_with($pdf, 'http'))
            return $pdf;
        return Storage::disk('public')->url($pdf);
    }

    public function category()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    public function partials()
    {
        return $this->hasMany(IncomePartial::class);
    }

    public function getPartialSumAttribute()
    {
        return $this->partials->sum('sum');
    }

    public function getPendingAttribute()
    {
        $amount = $this->format($this->amount);
        $tax = $this->format($this->withholding_tax);
        $partial = $this->partials->sum('sum');
        $iva = $this->iva;

        if ($iva < 0)
            return $amount - $tax - $partial;

        return $amount + ($amount * $iva / 100) - $tax - $partial;
    }

    private function format($value)
    {
        return str_replace(['.00', ',', '$'], "", $value);
    }

}
