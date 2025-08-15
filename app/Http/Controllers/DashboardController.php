<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with('agent', 'location', 'country');

        if ($q = $request->input('search')) {
            $query->where('name','like',"%{$q}%")
                ->orWhereHas('agent', fn($q2)=> $q2->where('name','like',"%{$q}%"));
        }
        if ($loc = $request->input('location')) {
            $query->where('location_id',$loc);
        }

        $properties = $query->where('agent_id', Auth::id())->paginate(10);

        $locations = Location::pluck('name','id');

        return view('dashboard', [
            'properties' => $properties,
            'propertyTypes' => \App\Models\PropertyType::all(),
            'propertyConditions' => \App\Models\PropertyCondition::all(),
            'furnishingStatuses' => \App\Models\FurnishingStatus::all(),
            'countries' => \App\Models\Country::all(),
            'locations' => $locations,
        ]);
    }
}
