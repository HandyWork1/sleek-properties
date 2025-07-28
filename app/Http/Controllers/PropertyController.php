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
        $q = Property::with('agent','location','country');

        if ($s = $request->search) {
            $q->where('name','like',"%{$s}%")
            ->orWhereHas('agent', fn($q2)=> $q2->where('name','like',"%{$s}%"));
        }
        if ($d = $request->start) {
            $q->whereDate('created_at','>=',$d);
        }
        if ($d2 = $request->end) {
            $q->whereDate('created_at','<=',$d2);
        }

        $perPage = $request->perPage ?: 10;
        $properties = $q->paginate($perPage);

        $locations = Location::pluck('name','id');

        return view('listings.index', compact('properties','locations'));
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
         // Decode hashid if using Hashidable or similar trait
        $property = Property::with([
            'media',          // Spatie MediaLibrary images
            'agent',          // The agent who listed the property
            'type',           // e.g., Apartment, Villa
            'condition',      // e.g., Newly Built
            'furnishingStatus', // e.g., Unfurnished
            'location',       // e.g., UAE, Dubai
            'landlord'        // If you want to show who owns it
        ])->where('id', $id)->firstOrFail();

        // Eager load media
        $images = $property->getMedia('images')->map(function ($media) {
            return [
                'thumb' => $media->getUrl('thumb'),
                'medium' => $media->getUrl('medium'),
                'large' => $media->getUrl('large'),
                'original' => $media->getUrl(),
            ];
        });

        // Fetch similar listings: same location or type, excluding current property
        $similarListings = Property::with('media')
            ->where('id', '!=', $property->id)
            ->where(function ($query) use ($property) {
                $query->where('location_id', $property->location_id)
                    ->orWhere('property_type_id', $property->property_type_id);
            })
            ->latest()
            ->take(2)
            ->get();

        return view('listings.show', compact('property', 'images', 'similarListings'));
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
