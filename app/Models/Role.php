<?php
namespace App\Models;
use Spatie\Permission\Models\Role as OriginalRole;
use App\Models\RoleHasPermissions;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
class Role extends OriginalRole
{
    protected $fillable = [
        'name',
        'status',
        'guard_name',
        'updated_at',
        'created_at',
        'code',
        'created_by',
        'updated_by'
    ];

    public static function getRoleList(){
        return Role::where('status', 'ACT')->orderBy('id', 'asc')->pluck('name', 'id');
    }

    public static function getRolePermissionIdList($roleId){
        return RoleHasPermissions::where('role_id', $roleId)->pluck('permission_id');
    }

    public static function getRolePermissions($roleId){
        $permissionIdList = Role::getRolePermissionIdList($roleId);
        $permissionNameList = Permission::whereIn('id', $permissionIdList)->where('status', 'ACT')->pluck('name')->toArray();
        if($permissionNameList)
            return implode(', ', $permissionNameList);
        return;
    }

    public static function assignRolePermissions($roleId, $permissionIdList){
        $existingRolePermission = RoleHasPermissions::where('role_id', $roleId);
        if(count($existingRolePermission->get()) > 0)
            $existingRolePermission->delete();
        $rolePermissionRecords = [];
        foreach($permissionIdList as $permissionId)
            $rolePermissionRecords[] = [
                'permission_id' => $permissionId,
                'role_id' => $roleId,
                'created_by' => Auth::user()->id
            ];
        if(RoleHasPermissions::insert($rolePermissionRecords));
            return true;
        return false;
    }
}