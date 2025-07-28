<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyCondition;
use App\Models\FurnishingStatus;
use App\Models\Country;
use App\Models\Location;
use App\Models\Landlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
   public function index(Request $request)
    {
        
    }



    // public function create()
    // {
    //     return view('listings.create', [
    //         'types' => PropertyType::all(),
    //         'conditions' => PropertyCondition::all(),
    //         'furnishings' => FurnishingStatus::all(),
    //         'countries' => Country::all(),
    //         'locations' => Location::all(),
    //         'landlords' => Landlord::all(),
    //     ]);
    // }

    public function store(Request $request)
    {
        try {
            // Validate the request data
        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'size' => 'required|numeric',
            'price' => 'required|numeric',
            'status' => 'required|in:for_sale,for_rent,sold,rented',
            'property_type_id' => 'required|exists:property_types,id',
            'property_condition_id' => 'required|exists:property_conditions,id',
            'furnishing_status_id' => 'required|exists:furnishing_statuses,id',
            'country_id' => 'required|exists:countries,id',
            'location_id' => 'required|exists:locations,id',
            'landlord_id' => 'nullable|exists:landlords,id',
            'images.*' => 'nullable|image|max:5120'
        ]);

        $property = Property::create([
            ...$request->only([
                'name', 'description', 'bedrooms', 'bathrooms', 'size',
                'price', 'status', 'property_type_id', 'property_condition_id',
                'furnishing_status_id', 'country_id', 'location_id', 'landlord_id'
            ]),
            'agent_id' => Auth::id(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $property->addMedia($image)->toMediaCollection('images');
            }
        }

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Property successfully created!',
            'timeout' => 4000,
        ]);

        } catch (\Throwable $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => 'An error occurred while creating the property: ' . $e->getMessage(),
                'timeout' => 4000,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
