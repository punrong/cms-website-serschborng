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
            'payload' => PrimevueDatatables::of(Role::select('id', 'name', 'status')->where('status', '!=', 'DEL')->orderBy($sortField, $sortOrder))->make()
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
            return response()->json([
                'success' => true,
            ]);
    }

    public function show(Role $role)
    {
        return Inertia::render('Admin/Role/Detail', [
            'role' => $role,
        ]);
    }

    public function edit(Role $role, Request $request)
    {
        return Inertia::render('Admin/Role/Edit', [
            'role' => $role,
            'isTriggeredFromTable' => $request->isTriggeredFromTable ?? false
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $this->validateRequest($request);
        $this->assignValue($request, $role);
        if ($role->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function destroy(Role $role)
    {
        $role->status = 'DEL';
        if ($role->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function deleteMultipleRecord(Request $request)
    {
        $roleIdList = array_column($request->roleList, 'id');
        if (Role::whereIn('id', $roleIdList)->update(['status' => 'DEL']))
            return response()->json([
                'success' => true,
            ]);
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
