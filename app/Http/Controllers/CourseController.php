<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $courses,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name'    => 'required|string|max:255',
            'description'    => 'required|string',
            'duration_month' => 'required|integer|min:1'
        ]);

        $validated['created_at'] = now(); 

        $course = Course::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Course created successfully',
            'data' => $course
        ], 201);
    }

    public function show($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'status'  => 404,
                'message' => 'Course not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data'   => $course
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'status'  => 404,
                'message' => 'Course not found'
            ], 404);
        }

        $validated = $request->validate([
            'course_name'    => 'required|string|max:255',
            'description'    => 'required|string',
            'duration_month' => 'required|integer|min:1'
        ]);

        $course->update($validated);

        return response()->json([
            'status'  => 200,
            'message' => 'Course updated successfully',
            'data'    => $course
        ], 200);
    }

    public function destroy(string $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'status'  => 404,
                'message' => 'Course not found'
            ], 404);
        }

        $course->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Course deleted successfully'
        ], 200);
    }
}
