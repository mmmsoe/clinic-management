<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicDay extends Model
{

    use HasFactory;

    protected $fillable = ['clinic_id', 'day'];
    
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function operationHours()
    {
        return $this->hasMany(OperationHour::class);
    }
}
