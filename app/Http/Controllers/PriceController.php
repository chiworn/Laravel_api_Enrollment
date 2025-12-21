<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    // List all prices
    public function index()
    {
        $prices = DB::table('tb_price')->get();
        return response()->json([
            'message' => 'success ',
            'Data'    => $prices 
        ]);
    }

    // Store new price
    public function store(Request $request)
    {
        $request->validate([
            'price_course' => 'required|numeric',
        ]);

        $id = DB::table('tb_price')->insertGetId([
            'price_course' => $request->price_course,
            'created_at' => now()
        ]);

        $price = DB::table('tb_price')->where('id', $id)->first();
        return response()->json($price, 201);
    }

    // Show single price
    public function show($id)
    {
        $price = DB::table('tb_price')->where('id', $id)->first();
        if (!$price) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($price);
    }

    // Update price
    public function update(Request $request, $id)
    {
        $request->validate([
             'price_course' => 'required|numeric',
        ]);

        $updated = DB::table('tb_price')->where('id', $id)->update([
            'price_course' => $request->price_course,
        ]);

        if (!$updated) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $price = DB::table('tb_price')->where('id', $id)->first();
        return response()->json([
            'message' => 'update success',
            'data' => $price
        ]);
    }

    // Delete price
    public function destroy($id)
    {
        $deleted = DB::table('tb_price')->where('id', $id)->delete();
        if (!$deleted) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json(['message' => 'Deleted successfully']);
    }
}
