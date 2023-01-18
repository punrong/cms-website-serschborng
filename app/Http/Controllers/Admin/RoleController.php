<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
        $roles = (new Role)->newQuery();
        $roles->where('status', '!=', 'DEL')->latest();
        $roles = $roles->paginate(100)->onEachSide(2)->appends(request()->query());
        return Inertia::render('Admin/Role/Index', [
            'roles' => $roles,
            'can' => [
                'create' => Auth::user()->can('role create'),
                'edit' => Auth::user()->can('role edit'),
                'delete' => Auth::user()->can('role delete'),
            ]
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
            return redirect()->route('role.index')->with('message', 'Role Added Successfully');
    }

    public function show(Role $role)
    {
        return Inertia::render('Admin/Role/Show', [
            'role' => $role,
        ]);
    }

    public function edit(Role $role)
    {
        return Inertia::render('Admin/Role/Edit', [
            'role' => $role
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $this->validateRequest($request);
        $this->assignValue($request, $role);
        if ($role->save())
            return redirect()->route('role.index')->with('message', 'Role Updated Successfully');
    }

    public function destroy(Role $role)
    {
        $role->status = 'DEL';
        if ($role->save())
            return redirect()->route('role.index')->with('message', 'Role Deleted Successfully');
    }

    public function deleteMultiple(Request $request){
        $roleIdList = array_column($request->roleList, 'id');
        if(Role::whereIn('id', $roleIdList)->update(['status' => 'DEL']))
            return redirect()->route('role.index')->with('message', 'Role Updated Successfully');
    }

    private function validateRequest($request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
    }

    private function assignValue($request, $role)
    {
        $role->name = $request->name;
        $role->status = $request->status;
    }
}
