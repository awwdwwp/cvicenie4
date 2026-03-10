<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = DB::table('categories')
            ->orderBY('updated_at', 'DESC')
            ->get();
        return response()->json(['categories' => $categories], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('categories')->insert([
            'id' => $request->id,
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'message' => 'Kategoria bola uspesne vytvorena.'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = DB::table('categories')
            ->where('id', $id)
            ->first();
        if (!$category) {
            return response()->json([
                'message' => 'Kategoria nenajdena.'
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['category' => $category], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            return response()->json([
                'message' => 'Kategoria nenalezena.'
            ], Response::HTTP_NOT_FOUND);
        }

        DB::table('categories')->where('id', $id)->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Kategoria bola uspesne upravena.'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            return response()->json([
                'message' => 'Kategoria nenalezena.'
            ], Response::HTTP_NOT_FOUND);
        }
        DB::table('categories')->where('id', $id)->delete(); //HARD DELETE only

        return response()->json([
           'message' => 'Kategoria odstranena'
        ], Response::HTTP_OK);
    }
}
