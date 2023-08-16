<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MyMentorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Savannabits\PrimevueDatatables\PrimevueDatatables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class MyMentorProfileController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/MyMentorProfile/Index');
    }

    public function getMentorData(Request $request): JsonResponse
    {
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        return response()->json([
            'success' => true,
            'payload' => PrimevueDatatables::of(MyMentorProfile::select('id', 'name', 'email', 'phone_number', 'status')->where('status', '!=', 'DEL')->where('email',Auth::user()->email)->orderBy($sortField, $sortOrder))->make()
        ]);
    }

    public function show(MyMentorProfile $myMentorProfile)
    {
        $myMentorProfile->image = $myMentorProfile->image ? asset($myMentorProfile->image) : null;
        return Inertia::render('Admin/MyMentorProfile/Detail', [
            'mentor' => $myMentorProfile,
        ]);
    }

    public function edit(MyMentorProfile $myMentorProfile, Request $request)
    {
        $myMentorProfile->image = $myMentorProfile->image ? asset($myMentorProfile->image) : null;
        return Inertia::render('Admin/MyMentorProfile/Edit', [
            'mentor' => $myMentorProfile,
            'isTriggeredFromTable' => $request->isTriggeredFromTable ?? false
        ]);
    }

    public function update(MyMentorProfile $myMentorProfile, Request $request)
    {
        $this->validateRequest($request, $myMentorProfile);
        $this->assignValue($request, $myMentorProfile);
        if ($myMentorProfile->save())
            return response()->json([
                'success' => true,
            ]);
    }

    private function validateRequest($request, $myMentorProfile = null)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', isset($myMentorProfile) ? 'unique:mentors,email,' . $myMentorProfile->id . ',id' : 'unique:mentors'],
            // 'phone_number' => ['string', 'max:20', isset($mentor) ? 'unique:mentors,phone_number,' . $mentor->id . ',id' : 'unique:mentors', 'regex:/^\d{9,10}$/'],
            'status' => 'required',
            'image' => 'max:2048',
            'description' => ['required', 'string'],
        ]);
    }

        private function assignValue($request, $myMentorProfile)
    {
        $myMentorProfile->name = $request->name;
        $myMentorProfile->email = $request->email;
        $myMentorProfile->status = $request->status;
        $myMentorProfile->phone_number = $request->phone_number;
        $myMentorProfile->description = $request->description;
        if(Auth::check()){
            if(isset($myMentorProfile->id))
                $myMentorProfile->updated_by = Auth::user()->id;
            else
                $myMentorProfile->created_by = Auth::user()->id;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $myMentorProfile->image = 'images/' . $imageName;
        }

        if (!isset($request->image) && isset($myMentorProfile->image)) {

            if (File::exists(public_path($myMentorProfile->image))) {
                // Delete the file
                File::delete(public_path($myMentorProfile->image));
            }
            $myMentorProfile->image = null;
        }
    }
}
