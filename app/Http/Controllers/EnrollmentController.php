<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Enrollment::with(['course', 'timeslot', 'termslot', 'price'])
            ->orderBy('id', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }
                $q->orWhere('Frist_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        $enrollments = $query->get();

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data'   => $enrollments
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'   => 'required|exists:tb_course,id',
            'timeslot_id' => 'required|exists:tb_timeslot,id',
            'term_id'     => 'required|exists:tb_ternslot,id',
            'price_id'    => 'required|exists:tb_price,id',
            'Frist_name'  => 'required|string|max:90',
            'last_name'   => 'required|string|max:100',
            'phone'       => 'required|string|max:50',
            'email'       => 'required|email|max:100',
            'status'      => 'nullable|string'
        ]);

        $enrollment = Enrollment::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Enrollment created successfully',
            'data' => $enrollment
        ], 201);
    }

    public function show($id)
    {
        $enrollment = Enrollment::with(['course', 'timeslot', 'termslot', 'price'])->find($id);

        if (!$enrollment) {
            return response()->json([
                'status' => 404,
                'message' => 'Not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $enrollment
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json([
                'status' => 404,
                'message' => 'Enrollment not found'
            ], 404);
        }

        $validated = $request->validate([
            'course_id'   => 'required|exists:tb_course,id',
            'timeslot_id' => 'required|exists:tb_timeslot,id',
            'term_id'     => 'required|exists:tb_ternslot,id',
            'price_id'    => 'required|exists:tb_price,id',
            'Frist_name'  => 'required|string|max:90',
            'last_name'   => 'required|string|max:100',
            'phone'       => 'required|string|max:50',
            'email'       => 'required|email|max:100',
            'status'      => 'required|string'
        ]);

        $enrollment->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Enrollment updated successfully',
            'data' => $enrollment
        ], 200);
    }

    public function destroy(string $id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json([
                'status' => 404,
                'message' => 'Enrollment not found'
            ], 404);
        }
        
        $enrollment->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Enrollment deleted'
        ], 200);
    }
}
