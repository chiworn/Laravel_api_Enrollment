<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course = DB::table('tb_course')->get();
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
            'course_name'      => 'required|string|max:255',
            'description'      => 'required|string',
            'duration_month'   => 'required|integer|min:1'
        ]);

        $id = DB::table('tb_course')->insertGetId([
            'course_name'     => $request->course_name,
            'description'     => $request->description,
            'duration_month'  => $request->duration_month,
            'created_at'      => now()
        ]);

        return response()->json([
            'status' => 202,
            'message' => 'Course created successfully',
            'course_id' => $id
        ], 202);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
         $course = DB::table('tb_course')->where('id', $id)->first();

        if (!$course) {
            return response()->json([
                'status'  => 404,
                'message' => 'Course not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data'   => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'course_name'      => 'required|string|max:255',
            'description'      => 'required|string',
            'duration_month'   => 'required|integer|min:1'
        ]);

        $updated = DB::table('tb_course')
            ->where('id', $id)
            ->update([
                'course_name'    => $request->course_name,
                'description'    => $request->description,
                'duration_month' => $request->duration_month,
                'created_at'      => now()
            ]);

        if (!$updated) {
            return response()->json([
                'status'  => 404,
                'message' => 'Course not found or no changes made'
            ], 404);
        }

        return response()->json([
            'status'  => 200,
            'message' => 'Course updated successfully'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $deleted = DB::table('tb_course')->where('id', $id)->delete();

        if (!$deleted) {
            return response()->json([
                'status'  => 404,
                'message' => 'Course not found'
            ], 404);
        }

        return response()->json([
            'status'  => 200,
            'message' => 'Course deleted successfully'
        ]);
    }
}
