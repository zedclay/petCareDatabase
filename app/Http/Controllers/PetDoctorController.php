<?php

namespace App\Http\Controllers;

use App\Models\PetDoctor;
use Illuminate\Http\Request;

class PetDoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $petDoctors = PetDoctor::with('reviews')->get();

        return response()->json($petDoctors, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $fields = $request->validate([
            'name' => 'required|string',
            'clinic_name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'photo' => 'nullable|string',
        ]);

        $petDoctor = PetDoctor::create([
            'name' => $fields['name'],
            'clinic_name' => $fields['clinic_name'],
            'address' => $fields['address'],
            'phone_number' => $fields['phone_number'],
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('public/doctors/photos');
            $petDoctor->photo = $path;
            $petDoctor->save();
        }

        return response()->json($petDoctor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $petDoctor = PetDoctor::with('reviews')->findOrFail($id);

        return response()->json($petDoctor, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $fields = $request->validate([
            'name' => 'required|string',
            'clinic_name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'photo' => 'nullable|string',
        ]);

        $petDoctor = PetDoctor::findOrFail($id);

        $petDoctor->update($fields);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('public/doctors/photos');
            $petDoctor->photo = $path;
            $petDoctor->save();
        }

        return response()->json($petDoctor, 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $petDoctor = PetDoctor::findOrFail($id);
        
        $petDoctor->delete();

        return response()->json(null, 200);
    }
}
