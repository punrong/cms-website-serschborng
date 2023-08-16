<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MyAppointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Savannabits\PrimevueDatatables\PrimevueDatatables;
use Illuminate\Http\JsonResponse;
use App\Models\Mentor;
use App\Models\Post;

class MyAppointmentController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/MyAppointment/Index');
    }

    public function getAppointmentData(Request $request): JsonResponse
    {
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        return response()->json([
            'success' => true,
            'payload' => PrimevueDatatables::of(MyAppointment::with('mentee')->with('mentor')->with('opportunity')->select('id', 'mentee_id', 'mentor_id', 'status', 'method', 'opportunity_id', 'appointment_datetime')->where('status', '!=', 'DEL')->where('mentee_id', Auth::user()->id)->orderBy($sortField, $sortOrder))->make()
        ]);
    }

    public function show(MyAppointment $myAppointment)
    {
        $myAppointment->mentee = User::getUsername($myAppointment->mentee_id);
        $myAppointment->mentor = Mentor::getMentorName($myAppointment->mentor_id);
        $myAppointment->opportunity = Post::getPostTitle($myAppointment->opportunity_id);
        return Inertia::render('Admin/MyAppointment/Detail', [
            'appointment' => $myAppointment,
        ]);
    }
}
