<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Savannabits\PrimevueDatatables\PrimevueDatatables;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:role list', ['only' => ['index', 'show']]);
        $this->middleware('can:role create', ['only' => ['create', 'store']]);
        $this->middleware('can:role edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:role delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return Inertia::render('Admin/Role/Index', [
            'can' => [
                'create' => Auth::user()->can('role create'),
                'edit' => Auth::user()->can('role edit'),
                'delete' => Auth::user()->can('role delete'),
            ]
        ]);
    }

    public function getRoleData(Request $request): JsonResponse {
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        return response()->json([
            'success' => true,
            'payload' => PrimevueDatatables::of(Role::select('id', 'name', 'code', 'status')->where('status', '!=', 'DEL')->orderBy($sortField, $sortOrder))->make()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Role/Create');
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $role = new Role();
        $this->assignValue($request, $role);
        if ($role->save())
            if(Role::assignRolePermissions($role->id, $request->permissions))
                return response()->json([
                    'success' => true,
                ]);
    }

    public function show(Role $role)
    {
        $role->permissions = Role::getRolePermissions($role->id);
        return Inertia::render('Admin/Role/Detail', [
            'role' => $role,
            'can' => [
                'edit' => Auth::user()->can('role edit'),
            ]
        ]);
    }

    public function edit(Role $role, Request $request)
    {
        $role->permissions = Role::getRolePermissionIdList($role->id);
        return Inertia::render('Admin/Role/Edit', [
            'role' => $role,
            'isTriggeredFromTable' => $request->isTriggeredFromTable ?? false
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $this->validateRequest($request, $role);
        $this->assignValue($request, $role);
        if ($role->save() && Role::assignRolePermissions($role->id, $request->permissions))
            return response()->json([
                'success' => true,
            ]);
    }

    public function destroy(Role $role)
    {
        $role->status = 'DEL';
        $role->updated_by = Auth::user()->id;
        if ($role->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function deleteMultipleRecord(Request $request)
    {
        $roleIdList = array_column($request->roleList, 'id');
        if (Role::whereIn('id', $roleIdList)->update(['status' => 'DEL', 'updated_by' => Auth::user()->id]))
            return response()->json([
                'success' => true,
            ]);
    }

    public function getRoleList(){
        return Role::getRoleList();
    }

    private function validateRequest($request, $role = null)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'status' => ['required'],
            'code' => ['required','string', isset($role) ? 'unique:roles,code,' . $role->id . ',id' : 'unique:roles']
        ]);
    }

    private function assignValue($request, $role)
    {
        $role->name = $request->name;
        $role->status = $request->status;
        $role->code = $request->code;
        if(isset($role->id))
            $role->updated_by = Auth::user()->id;
        else
            $role->created_by = Auth::user()->id;
    }
}
