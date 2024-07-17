<?php

namespace App\Http\Controllers;

use App\Models\FoundPet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FoundPetController extends Controller
{
    //
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $foundPets = FoundPet::with('user')->get();

        return response()->json($foundPets, 200);
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
            'species' => ['required', 'string'],
            'sex' => ['required', 'in:male,female'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'photo' => ['nullable', 'image'],
        ]);

        $qr_code_text = (string) Str::uuid();
        $user_id = $user->id;

        $foundPet = FoundPet::create([
            'category' => $fields['category'],
            'species' => $fields['species'],
            'sex' => $fields['sex'],
            'address' => $fields['address'],
            'qr_code_text' => $qr_code_text,
            'phone_number' => $fields['phone_number'],
            'user_id' => $user_id,
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('public/foundPets/photos');
            $foundPet->photo = $path;
            $foundPet->save();
        }

        return response()->json($foundPet, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $foundPet = FoundPet::with('user')->findOrFail($id);

        return response()->json($foundPet, 200);
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
            'species' => ['string'],
            'sex' => ['in:male,female'],
            'address' => ['string'],
            'phone_number' => ['string'],
            'photo' => ['nullable', 'image'],
        ]);

        $foundPet = FoundPet::findOrFail($id);

        if ($foundPet->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $foundPet->update($fields);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('public/foundPets/photos');
            $foundPet->photo = $path;
            $foundPet->save();
        }

        return response()->json($foundPet, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $foundPet = FoundPet::findOrFail($id);

        $foundPet->delete();

        return response()->json(null, 204);
    }

    public function filterByCategory(string $category)
    {
        $foundPets = FoundPet::with('user')
            ->where('category', $category)
            ->get();

        return response()->json($foundPets, 200);
    }

    public function getCurrentUserFoundPets(Request $request)
    {
        $user = $request->user();

        $foundPets = FoundPet::where('user_id', $user->id)->get();

        return response()->json($foundPets, 200);
    }

    public function searchByQrCodeText(Request $request)
    {
        $fields = $request->validate([
            'qr_code_text' => ['required', 'string', 'uuid'],
        ]);

        $foundPet = FoundPet::where('qr_code_text', $fields['qr_code_text'])->first();

        return response()->json($foundPet, 200);
    }
}
