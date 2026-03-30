<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        $prices = Price::all();
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $prices
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'price_course' => 'required|numeric',
        ]);

        $validated['created_at'] = now();
        $price = Price::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Price created successfully',
            'data' => $price
        ], 201);
    }

    public function show($id)
    {
        $price = Price::find($id);

        if (!$price) {
            return response()->json([
                'status' => 404,
                'message' => 'Not Found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $price
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $price = Price::find($id);

        if (!$price) {
            return response()->json([
                'status' => 404,
                'message' => 'Not Found'
            ], 404);
        }

        $validated = $request->validate([
             'price_course' => 'required|numeric',
        ]);

        $price->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'update success',
            'data' => $price
        ], 200);
    }

    public function destroy($id)
    {
        $price = Price::find($id);

        if (!$price) {
            return response()->json([
                'status' => 404,
                'message' => 'Not Found'
            ], 404);
        }

        $price->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Deleted successfully'
        ], 200);
    }
}
