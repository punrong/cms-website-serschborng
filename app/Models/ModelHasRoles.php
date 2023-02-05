<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasRoles extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id',
    ];
}
