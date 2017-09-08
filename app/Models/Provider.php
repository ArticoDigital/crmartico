<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Provider extends Model
{
    protected $guarded = [];

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
