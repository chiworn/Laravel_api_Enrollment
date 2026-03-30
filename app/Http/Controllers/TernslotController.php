<?php

namespace App\Http\Controllers;

use App\Models\Termslot;
use Illuminate\Http\Request;

class TernslotController extends Controller
{
    public function index()
    {
        $terms = Termslot::all();
        return response()->json([
            'status' => 200,
            'data' => $terms
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tern_day' => 'required|string|max:255'
        ]);

        $validated['created_at'] = now();
        $term = Termslot::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Tern day added successfully',
            'data' => $term
        ], 201);
    }

    public function show($id)
    {
        $term = Termslot::find($id);

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

    public function update(Request $request, $id)
    {
        $term = Termslot::find($id);

        if (!$term) {
            return response()->json([
                'status' => 404,
                'message' => 'Tern day not found'
            ], 404);
        }

        $validated = $request->validate([
            'tern_day' => 'required|string|max:255'
        ]);

        $term->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Tern day updated successfully',
            'data' => $term
        ], 200);
    }

    public function destroy($id)
    {
        $term = Termslot::find($id);

        if (!$term) {
            return response()->json([
                'status' => 404,
                'message' => 'Tern day not found'
            ], 404);
        }

        $term->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Tern day deleted successfully'
        ], 200);
    }
}
