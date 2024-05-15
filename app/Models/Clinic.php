<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address'];

    public function clinicDays()
    {
        return $this->hasMany(ClinicDay::class);
    }

    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }
}
