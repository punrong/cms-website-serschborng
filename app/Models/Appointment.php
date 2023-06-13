<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'mentee',
        'mentor',
        'method',
        'appointment_datetime',
        'status',
        'description',
        'created_by',
        'updated_by'
    ];
}
