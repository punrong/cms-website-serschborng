<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermissions extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'role_id',
        'permission_id',
        'created_by',
    ];
}
