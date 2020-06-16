<?php

namespace App\Http\Controllers;

use App\Models\AnalyticType;
use App\Models\Property;
use App\Models\PropertyAnalytic;

use Illuminate\Http\Request;

class PropertyAnalyticsController extends Controller
{ 
  public function index(Request $request)
  {
    if ($request->has('suburb_title') || $request->has('state_title') || $request->has('country_title')) {
      
      $responseTitle = '';
      if ($request->has('suburb_title')) {
        $responseTitle = 'Suburb: ' . $request->suburb_title . '. ';
        $properties = Property::where('suburb', $request->suburb_title)
          ->get();
      } else if ($request->has('state_title')) { 
        $responseTitle = 'State: ' . $request->state_title . '. ';
        $properties = Property::where('state', $request->state_title)
          ->get();
      } else { 
        $responseTitle = 'Country: ' . $request->country_title . '. ';
        $properties = Property::where('country', $request->country_title)
          ->get();
      }
         
      $propertyAnalytics = PropertyAnalytic::whereIn('property_id', $properties->pluck('id')->toArray());
      $propertyAnalyticValues = $propertyAnalytics->pluck('value');

      $minValue = $propertyAnalytics->min('value');
      $maxValue = $propertyAnalytics->max('value'); 
      $medianValue = $propertyAnalyticValues->median(); 
      
      $summary = 'Min value: ' . $minValue . '. ';
      $summary .= 'Max value: ' . $maxValue . '. ';
      $summary .= 'Median value: ' . $medianValue . '. ';
      
      return redirect('/')->with('propertyAnalyticsInfoMessage', $responseTitle . $summary);
    } else {
      return redirect()->back()
        ->withErrors(['propertyAnalyticsErrorMessage' => 'Request is incorrect.']);
    }
  }
}
