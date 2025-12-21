<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeslotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $course = DB::table('tb_timeslot')->get();
        return response()->json([
            'status' => 202,
            'message'=>'success',
            'Data'  => $course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_time' => 'required|string|max:255',
            'end_time'   => 'required|string|max:255',
        ]);

        $id = DB::table('tb_timeslot')->insertGetId([
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'created_at' => now(),
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Timeslot added successfully',
            'timeslot_id' => $id
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $slot = DB::table('tb_timeslot')->where('id', $id)->first();

        if (!$slot) {
            return response()->json([
                'status' => 404,
                'message' => 'Timeslot not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'timeslot' => $slot
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          $slot = DB::table('tb_timeslot')->where('id', $id)->first();

        if (!$slot) {
            return response()->json([
                'status' => 404,
                'message' => 'Timeslot not found'
            ], 404);
        }

        DB::table('tb_timeslot')->where('id', $id)->update([
            'start_time' => $request->start_time ?? $slot->start_time,
            'end_time'   => $request->end_time ?? $slot->end_time,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Timeslot updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
         $slot = DB::table('tb_timeslot')->where('id', $id)->first();

        if (!$slot) {
            return response()->json([
                'status' => 404,
                'message' => 'Timeslot not found'
            ], 404);
        }

        DB::table('tb_timeslot')->where('id', $id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Timeslot deleted successfully'
        ]);
    }
}
