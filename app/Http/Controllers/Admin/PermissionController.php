<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Savannabits\PrimevueDatatables\PrimevueDatatables;
use Illuminate\Http\JsonResponse;
class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permission list', ['only' => ['index', 'show']]);
        $this->middleware('can:permission create', ['only' => ['create', 'store']]);
        $this->middleware('can:permission edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:permission delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return Inertia::render('Admin/Permission/Index', [
            'can' => [
                'create' => Auth::user()->can('permission create'),
                'edit' => Auth::user()->can('permission edit'),
                'delete' => Auth::user()->can('permission delete'),
            ]
        ]);
    }

    public function getPermissionData(): JsonResponse {
        return response()->json([
            'success' => true,
            'payload' => PrimevueDatatables::of(Permission::select('id', 'name', 'status')->where('status', '!=', 'DEL')->orderBy('id', 'desc'))->make()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Permission/Create');
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $permission = new Permission();
        $this->assignValue($request, $permission);
        if ($permission->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function show(Permission $permission)
    {
        return Inertia::render('Admin/Permission/Detail', [
            'permission' => $permission,
        ]);
    }

    public function edit(Permission $permission)
    {
        return Inertia::render('Admin/Permission/Edit', [
            'permission' => $permission
        ]);
    }

    public function update(Permission $permission, Request $request)
    {
        $this->validateRequest($request);
        $this->assignValue($request, $permission);
        if ($permission->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function destroy(Permission $permission)
    {
        $permission->status = 'DEL';
        if ($permission->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function deleteMultipleRecord(Request $request)
    {
        $permissionIdList = array_column($request->permissionList, 'id');
        if (Permission::whereIn('id', $permissionIdList)->update(['status' => 'DEL']))
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

    private function assignValue($request, $permission)
    {
        $permission->name = $request->name;
        $permission->status = $request->status;
    }
}
