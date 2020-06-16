<?php

namespace App\Http\Controllers;

use App\Models\AnalyticType;
use App\Models\Property;
use App\Models\PropertyAnalytic;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{ 
  public function index(Request $request)
  { 
    $properties = Property::get();
    $analyticTypes = AnalyticType::get();
    $propertyAnalytics = PropertyAnalytic::with('property', 'analytic_type')->orderBy('property_id')->get();
     
    $countries = Property::select('country')
        ->groupBy('country')
        ->orderBy('country')
        ->get()
        ->pluck('country');

    $states = Property::select('state')
            ->groupBy('state')
            ->orderBy('state')
            ->get()
            ->pluck('state');

    $suburbs = Property::select('suburb')
            ->groupBy('suburb')
            ->orderBy('suburb')
            ->get()
            ->pluck('suburb');
    
    return view('index', [ 
      'properties' => $properties,
      'analyticTypes' => $analyticTypes,
      'propertyAnalytics' => $propertyAnalytics,
      'countries' => $countries,
      'suburbs' => $suburbs,
      'states' => $states
    ]);
  }
}
