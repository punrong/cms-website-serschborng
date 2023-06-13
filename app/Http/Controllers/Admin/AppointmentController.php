<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Savannabits\PrimevueDatatables\PrimevueDatatables;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {

    }

    public function create()
    {

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

    }

    public function edit(Appointment $appointment, Request $request)
    {

    }

    public function update(Appointment $appointment, Request $request)
    {

    }

    public function destroy(Appointment $appointment)
    {

    }

    public function deleteMultipleRecord(Request $request)
    {

    }


    private function validateRequest($request, $appointment = null)
    {
        $request->validate([
            'mentee' => 'required',
            'mentor' => 'required',
            'method' => 'required',
            'appointment_datetime' => ['required','date','after_or_equal:now'],
            'description' => 'required',
            'status' => 'required'
        ]);
    }

    private function assignValue($request, $appointment)
    {
        $appointment->mentee = $request->mentee;
        $appointment->mentor = $request->mentor;
        $appointment->method = $request->method;
        $appointment->appointment_datetime = $request->appointment_datetime;
        $appointment->description = $request->description;
        $appointment->status = $request->status;
        $appointment->opportunity_id = $request->opportunity_id ?? null;
        if(isset($appointment->id))
            $appointment->updated_by = Auth::user()->id;
        else
            $appointment->created_by = Auth::user()->id;
    }
}
