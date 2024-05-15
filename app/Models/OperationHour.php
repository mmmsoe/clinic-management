<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationHour extends Model
{
    use HasFactory;

    protected $fillable = ['clinic_day_id', 'start_time', 'end_time', 'is_booked'];

    public function clinicDay()
    {
        return $this->belongsTo(ClinicDay::class);
    }
}
