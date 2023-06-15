<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\ModelHasRoles;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'image',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function assignUserRole($userId, $role){
        $userRole = ModelHasRoles::where('model_id', $userId)->first();
        if($userRole){
            $userRole->role_id = $role;
            if($userRole->save())
                return true;
        }
        else{
            $newUserRole = new ModelHasRoles();
            $newUserRole->role_id = $role;
            $newUserRole->model_type = 'App\Models\User';
            $newUserRole->model_id = $userId;
            if($newUserRole->save())
                return true;
        }
        return false;
    }

    public static function getUserRoleId($userId){
        return ModelHasRoles::where('model_id', $userId)->value('role_id');
    }

    public static function getUserRoleName($userId){
        $roleId = ModelHasRoles::where('model_id', $userId)->value('role_id');
        return Role::where('id', $roleId)->value('name');
    }

    public static function getUsername($userId){
        return User::where('id', $userId)->value('name');
    }

    public static function getMenteeListAsObject(){
        return User::where('status', 'ACT')->orderBy('id', 'asc')->pluck('name', 'id');
    }

    public static function getUserEmail($userId){
        return User::where('id', $userId)->value('email');
    }
}
