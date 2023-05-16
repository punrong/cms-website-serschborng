<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Savannabits\PrimevueDatatables\PrimevueDatatables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class MentorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mentor list', ['only' => ['index', 'show']]);
        $this->middleware('can:mentor create', ['only' => ['create', 'store']]);
        $this->middleware('can:mentor edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:mentor delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return Inertia::render('Admin/Mentor/Index', [
            'can' => [
                'create' => Auth::user()->can('mentor create'),
                'edit' => Auth::user()->can('mentor edit'),
                'delete' => Auth::user()->can('mentor delete'),
            ]
        ]);
    }

    public function getMentorData(Request $request): JsonResponse
    {
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        return response()->json([
            'success' => true,
            'payload' => PrimevueDatatables::of(Mentor::select('id', 'name', 'email', 'phone_number', 'status')->where('status', '!=', 'DEL')->orderBy($sortField, $sortOrder))->make()
        ]);
    }
    public function create()
    {
        return Inertia::render('Admin/Mentor/Create');
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $mentor = new Mentor();
        $this->assignValue($request, $mentor);
        if ($mentor->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function show(Mentor $mentor)
    {
        $mentor->image = $mentor->image ? asset($mentor->image) : null;
        return Inertia::render('Admin/Mentor/Detail', [
            'mentor' => $mentor,
            'can' => [
                'edit' => Auth::user()->can('mentor edit')
            ]
        ]);
    }

    public function edit(Mentor $mentor, Request $request)
    {
        $mentor->image = $mentor->image ? asset($mentor->image) : null;
        return Inertia::render('Admin/Mentor/Edit', [
            'mentor' => $mentor,
            'isTriggeredFromTable' => $request->isTriggeredFromTable ?? false
        ]);
    }

    public function update(Mentor $mentor, Request $request)
    {
        $this->validateRequest($request, $mentor);
        $this->assignValue($request, $mentor);
        if ($mentor->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function destroy(Mentor $mentor)
    {
        $mentor->status = 'DEL';
        if ($mentor->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function deleteMultipleRecord(Request $request)
    {
        $mentorIdList = array_column($request->mentorList, 'id');
        if (Mentor::whereIn('id', $mentorIdList)->update(['status' => 'DEL']))
            return response()->json([
                'success' => true,
            ]);
    }

    private function validateRequest($request, $mentor = null)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', isset($mentor) ? 'unique:mentors,email,' . $mentor->id . ',id' : 'unique:mentors'],
            'phone_number' => ['string', 'max:20', isset($mentor) ? 'unique:mentors,phone_number,' . $mentor->id . ',id' : 'unique:mentors', 'regex:/^\d{9,10}$/'],
            'status' => 'required',
            'image' => 'max:2048',
            'description' => ['required', 'string'],
        ]);
    }

    private function assignValue($request, $mentor)
    {
        $mentor->name = $request->name;
        $mentor->email = $request->email;
        $mentor->status = $request->status;
        $mentor->phone_number = $request->phone_number;
        $mentor->description = $request->description;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $mentor->image = 'images/' . $imageName;
        }

        if (!isset($request->image) && isset($mentor->image)) {

            if (File::exists(public_path($mentor->image))) {
                // Delete the file
                File::delete(public_path($mentor->image));
            }
            $mentor->image = null;
        }
    }
}
