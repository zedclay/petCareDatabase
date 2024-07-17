<?php

namespace App\Http\Controllers;

use App\Models\DisappearedPet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DisappearedPetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $disappeatedPets = DisappearedPet::with('user')->get();

        return response()->json($disappeatedPets, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $fields = $request->validate([
            'category' => ['required', 'string'],
            'name' => ['required', 'string'],
            'species' => ['required', 'string'],
            'sex' => ['required', 'in:male,female'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'photo' => ['nullable', 'image'],
        ]);

        $qr_code_text = (string) Str::uuid();
        $user_id = $user->id;

        $disappearedPet = DisappearedPet::create([
            'category' => $fields['category'],
            'name' => $fields['name'],
            'species' => $fields['species'],
            'sex' => $fields['sex'],
            'qr_code_text' => $qr_code_text,
            'address' => $fields['address'],
            'phone_number' => $fields['phone_number'],
            'user_id' => $user_id,
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('public/disappearedPets/photos');
            $disappearedPet->photo = $path;
            $disappearedPet->save();
        }

        return response()->json($disappearedPet, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $disappearedPet = DisappearedPet::with('user')->findOrFail($id);

        return response()->json($disappearedPet, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = $request->user();

        $fields = $request->validate([
            'category' => ['string'],
            'name' => ['string'],
            'species' => ['string'],
            'sex' => ['in:male,female'],
            'address' => ['string'],
            'phone_number' => ['string'],
            'photo' => ['nullable', 'image'],
        ]);

        $disappearedPet = DisappearedPet::findOrFail($id);

        if ($disappearedPet->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $disappearedPet->update($fields);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('public/disappearedPets/photos');
            $disappearedPet->photo = $path;
            $disappearedPet->save();
        }

        return response()->json($disappearedPet, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $disappearedPet = DisappearedPet::findOrFail($id);

        $disappearedPet->delete();

        return response()->json(null, 204);
    }

    public function filterByCategory(string $category)
    {
        $disappearedPets = DisappearedPet::with('user')
            ->where('category', $category)
            ->get();

        return response()->json($disappearedPets, 200);
    }

    public function getCurrentUserDisappearedPets(Request $request)
    {
        $user = $request->user();

        $disappearedPets = DisappearedPet::where('user_id', $user->id)->get();

        return response()->json($disappearedPets, 200);
    }

    public function searchByQrCodeText(Request $request)
    {
        $fields = $request->validate([
            'qr_code_text' => ['required', 'string', 'uuid'],
        ]);

        $disappearedPet = DisappearedPet::where('qr_code_text', $fields['qr_code_text'])->first();

        return response()->json($disappearedPet, 200);
    }

}
