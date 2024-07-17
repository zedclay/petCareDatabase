<?php

namespace App\Http\Controllers;

use App\Models\PetSupplier;
use Illuminate\Http\Request;

class PetSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $petSuppliers = PetSupplier::with('reviews')->get();

        return response()->json($petSuppliers, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $fields = $request->validate([
            'pet_house' => 'required|string',
            'address' => 'required|string',
            'contact' => 'required|string',
            'website' => 'required|string',
            'photo' => 'nullable|string',
        ]);

        $petSupplier = PetSupplier::create([
            'pet_house' => $fields['name'],
            'address' => $fields['address'],
            'contact' => $fields['contact'],
            'website' => $fields['website'],
            'phone_number' => $fields['phone_number'],
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('public/suppliers/photos');
            $petSupplier->photo = $path;
            $petSupplier->save();
        }

        return response()->json($petSupplier, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $petSupplier = PetSupplier::with('reviews')->findOrFail($id);

        return response()->json($petSupplier, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $fields = $request->validate([
            'pet_house' => 'required|string',
            'address' => 'required|string',
            'contact' => 'required|string',
            'website' => 'required|string',
            'photo' => 'nullable|string',
        ]);

        $petSupplier = PetSupplier::findOrFail($id);

        $petSupplier->update($fields);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('public/suppliers/photos');
            $petSupplier->photo = $path;
            $petSupplier->save();
        }

        return response()->json($petSupplier, 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $petSupplier = PetSupplier::findOrFail($id);
        
        $petSupplier->delete();

        return response()->json(null, 200);
    }
}
