<?php
namespace App\Models;
use Spatie\Permission\Models\Permission as OriginalPermission;
class Permission extends OriginalPermission
{
    protected $fillable = [
        'name',
        'guard_name',
        'updated_at',
        'created_at',
        'status',
        'created_by',
        'updated_by'
    ];

    public static function getPermissionList(){
        return Permission::select( 'name', 'id as value')->where('status', 'ACT')->orderBy('id', 'asc')->get();
    }
}