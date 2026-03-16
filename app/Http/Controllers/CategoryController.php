<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()
            ->orderByDesc('updated_at')
            ->get();
        return response()->json(['categories' => $categories], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = Category::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'message' => 'Kategoria bola uspesne vytvorena',
            'category' => $category,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
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
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Kategoria nenajdena.'
            ], Response::HTTP_NOT_FOUND);
        }

        $category->update([
            'name' => $request->name,
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
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Kategoria nenajdena.'
            ], Response::HTTP_NOT_FOUND);
        }
        $category->delete();

        return response()->json([
           'message' => 'Kategoria odstranena'
        ], Response::HTTP_OK);
    }
}
