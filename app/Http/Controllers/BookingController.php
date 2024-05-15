<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClinicDay;
use App\Models\OperationHour;
use App\Models\Clinic;

class BookingController extends Controller
{
    public function index()
    {
        $clinics = Clinic::all();
        return view('booking.index', compact('clinics'));
    }

    public function getClinicDays($clinic_id)
    {
        $clinicDays = ClinicDay::where('clinic_id', $clinic_id)->get();
        return response()->json($clinicDays);
    }

    public function getOperationHours($clinicId, $day)
    {
        // Fetch operation hours based on clinic ID and day
        // $operationHours = OperationHour::whereHas('clinicDay', function ($query) use ($clinicId, $day) {
        //     $query->where('clinic_id', $clinicId)->where('day', $day);
        // })->get();

        $operationHours = OperationHour::whereHas('clinicDay', function ($query) use ($clinicId, $day) {
            $query->where('clinic_id', $clinicId)->where('day', $day);
        })->where('is_booked', 1)->get();

        return response()->json($operationHours);
    }

    public function bookOperationHour(Request $request)
    {
        $operationHour = OperationHour::find($request->operation_hour_id);
        if ($operationHour) {
            $operationHour->is_booked = true;
            $operationHour->save();

            return response()->json(['message' => 'Operation hour booked successfully!']);
        }

        return response()->json(['message' => 'Operation hour not found!'], 404);
    }

    public function cancelOperationHour(Request $request)
    {
        $operationHour = OperationHour::find($request->operation_hour_id);
        if ($operationHour) {
            $operationHour->is_booked = false;
            $operationHour->save();

            return response()->json(['message' => 'Operation hour cancelled successfully!']);
        }

        return response()->json(['message' => 'Operation hour not found!'], 404);
    }

    public function addOperationHour(Request $request)
    {
        $clinicDay = ClinicDay::firstOrCreate([
            'clinic_id' => $request->clinic_id,
            'day' => $request->day
        ]);

        OperationHour::create([
            'clinic_day_id' => $clinicDay->id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_booked' => true
        ]);

        return response()->json(['message' => 'Operation hour added successfully!']);
    }
}
