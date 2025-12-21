<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TernslotController extends Controller
{
    // 🔹 Get all tern slots
    public function index()
    {
        $terms = DB::table('tb_ternslot')->get();

        return response()->json([
            'status' => 200,
            'data' => $terms
        ], 200);
    }

    // 🔹 Create new tern slot
    public function store(Request $request)
    {
        $request->validate([
            'tern_day' => 'required|string|max:255'
        ]);

        $id = DB::table('tb_ternslot')->insertGetId([
            'tern_day' => $request->tern_day,
            'created_at' => now()
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Tern day added successfully',
            'id' => $id
        ], 201);
    }

    // 🔹 Show one term by ID
    public function show($id)
    {
        $term = DB::table('tb_ternslot')->where('id', $id)->first();

        if (!$term) {
            return response()->json([
                'status' => 404,
                'message' => 'Tern day not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $term
        ], 200);
    }

    // 🔹 Update term slot
    public function update(Request $request, $id)
    {
        $term = DB::table('tb_ternslot')->where('id', $id)->first();

        if (!$term) {
            return response()->json([
                'status' => 404,
                'message' => 'Tern day not found'
            ], 404);
        }

        DB::table('tb_ternslot')->where('id', $id)->update([
            'tern_day' => $request->tern_day ?? $term->tern_day
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Tern day updated successfully'
        ], 200);
    }

    // 🔹 Delete a tern slot
    public function destroy($id)
    {
        $term = DB::table('tb_ternslot')->where('id', $id)->first();

        if (!$term) {
            return response()->json([
                'status' => 404,
                'message' => 'Tern day not found'
            ], 404);
        }

        DB::table('tb_ternslot')->where('id', $id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Tern day deleted successfully'
        ], 200);
    }
}
