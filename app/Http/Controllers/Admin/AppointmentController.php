<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Savannabits\PrimevueDatatables\PrimevueDatatables;
use Illuminate\Http\JsonResponse;
use App\Models\Mentor;
use App\Models\Post;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:appointment list', ['only' => ['index', 'show']]);
        $this->middleware('can:appointment create', ['only' => ['create']]);
        $this->middleware('can:appointment edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:appointment delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return Inertia::render('Admin/Appointment/Index', [
            'can' => [
                'create' => Auth::user()->can('appointment create'),
                'edit' => Auth::user()->can('appointment edit'),
                'delete' => Auth::user()->can('appointment delete'),
            ]
        ]);
    }

    public function getAppointmentData(Request $request): JsonResponse
    {
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        return response()->json([
            'success' => true,
            'payload' => PrimevueDatatables::of(Appointment::with('mentee')->with('mentor')->with('opportunity')->select('id', 'mentee_id', 'mentor_id', 'status', 'method', 'opportunity_id', 'appointment_datetime')->where('status', '!=', 'DEL')->orderBy($sortField, $sortOrder))->make()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Appointment/Create');
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $appointment = new Appointment();
        $this->assignValue($request, $appointment);
        if ($appointment->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function show(Appointment $appointment)
    {
        $appointment->mentee = User::getUsername($appointment->mentee_id);
        $appointment->mentor = Mentor::getMentorName($appointment->mentor_id);
        $appointment->opportunity = Post::getPostTitle($appointment->opportunity_id);
        return Inertia::render('Admin/Appointment/Detail', [
            'appointment' => $appointment,
            'can' => [
                'edit' => Auth::user()->can('appointment edit'),
            ]
        ]);
    }

    public function edit(Appointment $appointment, Request $request)
    {
        return Inertia::render('Admin/Appointment/Edit', [
            'appointment' => $appointment,
            'isTriggeredFromTable' => $request->isTriggeredFromTable ?? false
        ]);
    }

    public function update(Appointment $appointment, Request $request)
    {
        $this->validateRequest($request, $appointment);
        $this->assignValue($request, $appointment);
        if ($appointment->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->status = 'DEL';
        $appointment->updated_by = Auth::user()->id;
        if ($appointment->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function deleteMultipleRecord(Request $request)
    {
        $appointmentIdList = array_column($request->appointmentList, 'id');
        if (Appointment::whereIn('id', $appointmentIdList)->update(['status' => 'DEL', 'updated_by' => Auth::user()->id]))
            return response()->json([
                'success' => true,
            ]);
    }


    private function validateRequest($request, $appointment = null)
    {
        $request->validate([
            'mentee_id' => 'required',
            'mentor_id' => 'required',
            'method' => 'required',
            'appointment_datetime' => ['required', 'date', 'after_or_equal:now'],
            'description' => 'required',
            'status' => 'required'
        ]);
    }

    private function assignValue($request, $appointment)
    {
        $appointment->mentee_id = $request->mentee_id;
        $appointment->mentor_id = $request->mentor_id;
        $appointment->method = $request->method;
        $appointment->appointment_datetime = $request->appointment_datetime;
        $appointment->description = $request->description;
        $appointment->status = $request->status;
        $appointment->opportunity_id = $request->opportunity_id ?? null;
        if (isset($appointment->id))
            $appointment->updated_by = Auth::user()->id;
        else
            $appointment->created_by = Auth::user()->id;
    }
}
