<?php

namespace App\Http\Controllers;

use App\Models\Timeslot;
use Illuminate\Http\Request;

class TimeslotController extends Controller
{
    public function index()
    {
        $timeslots = Timeslot::all();
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $timeslots,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_time' => 'required|string|max:255',
            'end_time'   => 'required|string|max:255',
        ]);

        $validated['created_at'] = now();
        $timeslot = Timeslot::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Timeslot added successfully',
            'data' => $timeslot
        ], 201);
    }

    public function show($id)
    {
        $slot = Timeslot::find($id);

        if (!$slot) {
            return response()->json([
                'status' => 404,
                'message' => 'Timeslot not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $slot
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $slot = Timeslot::find($id);

        if (!$slot) {
            return response()->json([
                'status' => 404,
                'message' => 'Timeslot not found'
            ], 404);
        }

        $validated = $request->validate([
            'start_time' => 'sometimes|required|string|max:255',
            'end_time'   => 'sometimes|required|string|max:255',
        ]);

        $slot->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Timeslot updated successfully',
            'data' => $slot
        ], 200);
    }

    public function destroy($id)
    {
        $slot = Timeslot::find($id);

        if (!$slot) {
            return response()->json([
                'status' => 404,
                'message' => 'Timeslot not found'
            ], 404);
        }

        $slot->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Timeslot deleted successfully'
        ], 200);
    }
}
