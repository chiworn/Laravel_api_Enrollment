<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
{
    $search = $request->query('search');

    $data = DB::table('tb_enrollment')
        ->leftJoin('tb_course', 'tb_enrollment.course_id', '=', 'tb_course.id')
        ->leftJoin('tb_timeslot', 'tb_enrollment.timeslot_id', '=', 'tb_timeslot.id')
        ->leftJoin('tb_ternslot', 'tb_enrollment.term_id', '=', 'tb_ternslot.id')
        ->leftJoin('tb_price', 'tb_enrollment.price_id', '=', 'tb_price.id')
        ->select(
            'tb_enrollment.id',
            'tb_enrollment.course_id',
            'tb_enrollment.timeslot_id',
            'tb_enrollment.term_id',
            'tb_enrollment.price_id',

            'tb_enrollment.Frist_name',
            'tb_enrollment.last_name',
            'tb_enrollment.phone',
            'tb_enrollment.email',
            'tb_enrollment.status',

            'tb_course.course_name',
            'tb_timeslot.start_time',
            'tb_timeslot.end_time',
            'tb_ternslot.tern_day',
            'tb_price.price_course',

            'tb_enrollment.created_at'
        )

        // ✅ ADD SEARCH (ID + NAME)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {

                // Search by enrollment ID
                if (is_numeric($search)) {
                    $q->where('tb_enrollment.id', $search);
                }

                // Search by student name
                $q->orWhere('tb_enrollment.Frist_name', 'LIKE', "%{$search}%")
                  ->orWhere('tb_enrollment.last_name', 'LIKE', "%{$search}%");
            });
        })

        ->orderBy('tb_enrollment.id', 'desc')
        ->get();

    return response()->json([
        'status' => 200,
        'data'   => $data
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
   {
        $request->validate([
            'course_id'   => 'required|integer',
            'timeslot_id' => 'required|integer',
            'term_id'     => 'required|integer',
            'price_id'    => 'required|integer',
            'Frist_name'  => 'required|string|max:90',
            'last_name'   => 'required|string|max:100',
            'phone'       => 'required|string|max:50',
            'email'       => 'required|email|max:100'
        ]);

        $id = DB::table('tb_enrollment')->insertGetId([
            'course_id'   => $request->course_id,
            'timeslot_id' => $request->timeslot_id,
            'term_id'     => $request->term_id,
            'price_id'    => $request->price_id,
            'Frist_name'  => $request->Frist_name,
            'last_name'   => $request->last_name,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'status'      =>  $request->status,
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Enrollment created successfully',
            'id' => $id
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
   {
        $data  = DB::table('tb_enrollment')
            ->leftJoin('tb_course', 'tb_enrollment.course_id', '=', 'tb_course.id')
            ->leftJoin('tb_timeslot', 'tb_enrollment.timeslot_id', '=', 'tb_timeslot.id')
            ->leftJoin('tb_ternslot', 'tb_enrollment.term_id', '=', 'tb_ternslot.id')
            ->leftJoin('tb_price', 'tb_enrollment.price_id', '=', 'tb_price.id')
            ->select(
                'tb_enrollment.id',
                'tb_enrollment.Frist_name',
                'tb_enrollment.last_name',
                'tb_enrollment.phone',
                'tb_enrollment.email',
                'tb_enrollment.status',
                'tb_course.course_name',
                'tb_course.description',
                'tb_timeslot.start_time',
                'tb_timeslot.end_time',
                'tb_ternslot.tern_day',
                'tb_price.id',
                'tb_price.price_course',
                'tb_enrollment.created_at'
            )->where('tb_enrollment.id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'Not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'course_id'   => 'required|integer',
            'timeslot_id' => 'required|integer',
            'term_id'     => 'required|integer',
            'price_id'    => 'required|integer',
            'Frist_name'  => 'required|string|max:90',
            'last_name'   => 'required|string|max:100',
            'phone'       => 'required|string|max:50',
            'email'       => 'required|email|max:100',
            'status'      => 'required|string'
        ]);

        $updated = DB::table('tb_enrollment')
            ->where('id', $id)
            ->update([
                'course_id'   => $request->course_id,
                'timeslot_id' => $request->timeslot_id,
                'term_id'     => $request->term_id,
                'price_id'    => $request->price_id,
                'Frist_name'  => $request->Frist_name,
                'last_name'   => $request->last_name,
                'phone'       => $request->phone,
                'email'       => $request->email,
                'status'      => $request->status,
                'updated_at'  => now()
            ]);

        if (!$updated) {
            return response()->json([
                'status' => 404,
                'message' => 'Enrollment not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Enrollment updated successfully'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
   {
        $deleted = DB::table('tb_enrollment')->where('id', $id)->delete();

        if (!$deleted) {
            return response()->json([
                'status' => 404,
                'message' => 'Enrollment not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Enrollment deleted'
        ]);
    }
}
