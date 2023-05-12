<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Savannabits\PrimevueDatatables\PrimevueDatatables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user list', ['only' => ['index', 'show']]);
        $this->middleware('can:user create', ['only' => ['create', 'store']]);
        $this->middleware('can:user edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:user delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        return Inertia::render('Admin/User/Index', [
            'can' => [
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ]
        ]);
    }

    public function getUserData(Request $request): JsonResponse {
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        return response()->json([
            'success' => true,
            'payload' => PrimevueDatatables::of(User::select('id', 'name', 'email', 'status')->where('status', '!=', 'DEL')->orderBy($sortField, $sortOrder))->make()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/User/Create');
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $user = new User();
        $this->assignValue($request, $user);
        if ($user->save())  
            if(User::assignUserRole($user->id, $request->role))
                return response()->json([
                    'success' => true,
                ]);

    }

    public function show(User $user)
    {
        $user->role = User::getUserRoleName($user->id);
        $user->image = $user->image ? asset($user->image) : null;
        return Inertia::render('Admin/User/Detail', [
            'user' => $user,
            'can' => [
                'edit' => Auth::user()->can('user edit'),
            ]
        ]);
    }

    public function edit(User $user, Request $request)
    {
        $user->role = User::getUserRoleId($user->id);
        $user->image = $user->image ? asset($user->image) : null;
        return Inertia::render('Admin/User/Edit', [
            'user' => $user,
            'isTriggeredFromTable' => $request->isTriggeredFromTable ?? false
        ]);
    }

    public function update(User $user, Request $request)
    {
        $this->validateRequest($request);
        $this->assignValue($request, $user);
        if ($user->save() && User::assignUserRole($user->id, $request->role))
            return response()->json([
                'success' => true,
            ]);
    }

    public function destroy(User $user)
    {
        $user->status = 'DEL';
        if ($user->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function deleteMultipleRecord(Request $request)
    {
        $userIdList = array_column($request->userList, 'id');
        if (User::whereIn('id', $userIdList)->update(['status' => 'DEL']))
            return response()->json([
                'success' => true,
            ]);
    }

    private function validateRequest($request)
    {
        if($request->password)
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'password_confirm' => ['required','same:password'],
                'status' => 'required',
                'role' => 'required',
                'image' => 'max:2048',

            ]);
        else
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'status' => 'required',
                'role' => 'required',
                'image' => 'max:2048',
            ]);
    }

    private function assignValue($request, $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password)
            $user->password = Hash::make($request->password);
        $user->status = $request->status;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $user->image = 'images/'.$imageName;
        } 

        if(!isset($request->image) && isset($user->image)){
            
            if (File::exists(public_path($user->image))) {
                // Delete the file
                File::delete(public_path($user->image));
            }
            $user->image = null;
        }
    }
}