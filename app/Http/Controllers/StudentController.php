<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $students,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email_stu'  => 'required|email|unique:tb_students,email_stu',
            'phone_num'  => 'required|string|max:100',
            'gender'     => 'required|string',
        ]);

        $student = Student::create([
            'frist_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email_stu'  => $validated['email_stu'],
            'phone_num'  => $validated['phone_num'],
            'gender'     => $validated['gender'],
            'creat_at'   => now()
        ]);

        return response()->json([
            'status'  => 201,
            'message' => 'insert success',
            'data'    => $student,
        ], 201);
    }

    public function show(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Search successfully',
            'data' => $student,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found',
            ], 404);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email_stu'  => 'required|email|unique:tb_students,email_stu,' . $id,
            'phone_num'  => 'required|string|max:100',
            'gender'     => 'required|string',
        ]);

        $student->update([
            'frist_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email_stu'  => $validated['email_stu'],
            'phone_num'  => $validated['phone_num'],
            'gender'     => $validated['gender']
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Update student success',
            'data' => $student,
        ], 200);
    }

    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['status' => 404, 'message' => 'Student not found'], 404);
        }

        $student->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Delete Success',
        ], 200);
    }
}
