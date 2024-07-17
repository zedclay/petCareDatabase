<?php

namespace App\Http\Controllers;

use App\Models\PetDoctorReview;
use Illuminate\Http\Request;

class PetDoctorReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $petDoctorReviews = PetDoctorReview::with(['reviewer', 'reviewee'])->get();

        return response()->json($petDoctorReviews, 200);
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

        $petDoctorReview = PetDoctorReview::create([
            'reviewer_id' => $fields['reviewer_id'],
            'reviewee_id' => $fields['reviewee_id'],
            'rating' => $fields['rating'],
        ]);

        return response()->json($petDoctorReview, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $petDoctorReview = PetDoctorReview::with(['reviewer', 'reviewee'])->findOrFail($id);

        return response()->json($petDoctorReview, 200);
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

        $petDoctorReview = PetDoctorReview::findOrFail($id);

        $petDoctorReview->rating = $fields['rating'];

        $petDoctorReview->save();

        return response()->json($petDoctorReview, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $petDoctorReview = PetDoctorReview::findOrFail($id);

        $petDoctorReview->delete();

        return response()->json(null, 204);
    }
}
