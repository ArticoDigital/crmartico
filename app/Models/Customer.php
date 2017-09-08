<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    protected $fillable =
        ["name_customer", "address", "nit", "payment_conditions", "date", "note", "chamber_commerce", "rut"];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function getChamberCommerceAttribute($pdf)
    {
        return $this->storageUrl($pdf);
    }

    public function getRutAttribute($pdf)
    {
        return $this->storageUrl($pdf);
    }

    private function storageUrl($pdf)
    {
        if (!$pdf || starts_with($pdf, 'http'))
            return $pdf;
        return Storage::disk('public')->url($pdf);
    }
}
