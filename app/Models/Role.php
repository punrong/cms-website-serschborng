<?php
namespace App\Models;
use Spatie\Permission\Models\Role as OriginalRole;
class Role extends OriginalRole
{
    protected $fillable = [
        'name',
        'status',
        'guard_name',
        'updated_at',
        'created_at',
    ];

    public static function getRoleList(){
        return Role::where('status', 'ACT')->orderBy('id', 'asc')->pluck('name', 'id');
    }
}