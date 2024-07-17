<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pets = Pet::with('user')->get();

        return response()->json($pets, 200);
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
            'birth_date' => ['required', 'date'],
            'photo' => ['nullable', 'image'],
        ]);

        $qr_code_text = (string) Str::uuid();
        $user_id = $user->id;

        $pet = Pet::create([
            'category' => $fields['category'],
            'name' => $fields['name'],
            'species' => $fields['species'],
            'sex' => $fields['sex'],
            'birth_date' => $fields['birth_date'],
            'qr_code_text' => $qr_code_text,
            'user_id' => $user_id,
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('public/pets/photos');
            $pet->photo = $path;
            $pet->save();
        }

        return response()->json($pet, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $pet = Pet::with('user')->findOrFail($id);

        return response()->json($pet, 200);
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
            'birth_date' => ['date'],
            'photo' => ['image'],
        ]);

        $pet = Pet::findOrFail($id);

        if ($pet->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $pet->update($fields);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('public/pets/photos');
            $pet->photo = $path;
            $pet->save();
        }

        return response()->json($pet, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $pet = Pet::findOrFail($id);
        
        $pet->delete();

        return response()->json(null, 200);
    }

    public function getCurrentUserPets(Request $request)
    {
        $user = $request->user();

        $pets = Pet::where('user_id', $user->id)->get();

        return response()->json($pets, 200);
    }

    public function searchByQrCodeText(Request $request)
    {
        $fields = $request->validate([
            'qr_code_text' => ['required', 'string', 'uuid'],
        ]);

        $pet = Pet::where('qr_code_text', $fields['qr_code_text'])->first();

        return response()->json($pet, 200);
    }
}
