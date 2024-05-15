<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    protected $fillable = ['clinic_id', 'from_date', 'to_date', 'reason'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
