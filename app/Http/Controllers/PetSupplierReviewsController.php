<?php

namespace App\Http\Controllers;

use App\Models\PetSupplierReview;
use Illuminate\Http\Request;

class PetSupplierReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $petSupplierReviews = PetSupplierReview::with(['reviewer', 'reviewee'])->get();

        return response()->json($petSupplierReviews, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $fields = $request->validate([
            'reviewer_id' => 'required|integer',
            'reviewee_id' => 'required|integer',
            'rating' => 'required|integer|min:0|max:5',
        ]);

        $petSupplierReview = PetSupplierReview::create([
            'reviewer_id' => $fields['reviewer_id'],
            'reviewee_id' => $fields['reviewee_id'],
            'rating' => $fields['rating'],
        ]);

        return response()->json($petSupplierReview, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $petSupplierReview = PetSupplierReview::with(['reviewer', 'reviewee'])->findOrFail($id);

        return response()->json($petSupplierReview, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $fields = $request->validate([
            'rating' => 'required|integer|min:0|max:5',
        ]);

        $petSupplierReview = PetSupplierReview::findOrFail($id);

        $petSupplierReview->rating = $fields['rating'];

        $petSupplierReview->save();

        return response()->json($petSupplierReview, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $petSupplierReview = PetSupplierReview::findOrFail($id);

        $petSupplierReview->delete();

        return response()->json(null, 204);
    }

}
