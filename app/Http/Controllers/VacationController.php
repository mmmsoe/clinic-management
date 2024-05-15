<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinic;
use App\Models\Vacation;

class VacationController extends Controller
{
    public function index()
    {
        $clinics = Clinic::all();
        return view('vacation.index', compact('clinics'));
    }

    public function getVacations($clinic_id)
    {
        $vacations = Vacation::where('clinic_id', $clinic_id)->get();
        return response()->json($vacations);
    }

    public function addVacation(Request $request)
    {

        $validated = $request->validate([
            'clinic_id' => 'required|integer',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string|max:255',
        ]);

        Vacation::create([
            'clinic_id' => $validated['clinic_id'],
            'from_date' => $validated['from_date'],
            'to_date' => $validated['to_date'],
            'reason' => $validated['reason'],
        ]);
        return response()->json(['message' => 'Vacation added successfully!']);
    }

    public function cancelVacation(Request $request)
    {
        $vacation = Vacation::find($request->vacation_id);
        if ($vacation) {
            $vacation->delete();
            return response()->json(['message' => 'Vacation hour cancelled successfully!']);
        }
        return response()->json(['message' => 'Vacation hour not found!'], 404);
    }
}
