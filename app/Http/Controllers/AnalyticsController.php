<?php

namespace App\Http\Controllers;

use App\Models\AnalyticType;
use App\Models\Property;
use App\Models\PropertyAnalytic;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
      $properties = Property::get();
      $analyticTypes = AnalyticType::get();
          
      try {
        $request->validate([
          'property_id' => 'required|in:'.collect($properties)->pluck('id')->implode(','),
          'analytic_type_id' => 'required|in:'.collect($analyticTypes)->pluck('id')->implode(','),
          'value' => 'numeric'
        ]);
        
        $property = Property::find($request->property_id);
        $analyticType = AnalyticType::find($request->analytic_type_id);
        
        if (!is_null($property) && !is_null($analyticType)) {
          $propertyAnalytic = new PropertyAnalytic;
          
          $propertyAnalytic->value = $request->value; 
          
          $propertyAnalytic->property()->associate($property);
          $propertyAnalytic->analytic_type()->associate($analyticType);
          
          $propertyAnalytic->save();
           
          return redirect('/')->with('analyticCreateSuccessMessage', 'Value for property created successfully!');
        } else {
            return redirect()->back()
                ->withErrors(['analyticCreateErrorMessage' => 'Error creating property analytic: Can\'t find property/analytic type']);
        }
      }
      catch (ValidationException $e) {
          return redirect()->back()
              ->withErrors(['analyticCreateErrorMessage' => $e->validator->getMessageBag()]);
      }
      catch (Exception $e) {
          return redirect()->back()
              ->withErrors(['analyticCreateErrorMessage' => $e->getMessage()]);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $propertyAnalytics = PropertyAnalytic::get();
          
      try {
        $request->validate([
          'property_analytic_id' => 'required|in:'.collect($propertyAnalytics)->pluck('id')->implode(','),
          'value' => 'numeric'
        ]);
        
        $propertyAnalytic = PropertyAnalytic::find($request->property_analytic_id);
        
        if (!is_null($propertyAnalytic)) {
        
          $propertyAnalytic->value = $request->value;
          
          if ($propertyAnalytic->isDirty()) {
            $propertyAnalytic->save();
          }
          return redirect('/')->with('analyticUpdateSuccessMessage', 'Value for property updated successfully!');
        } else {
            return redirect()->back()
                ->withErrors(['analyticUpdateSuccessMessage' => 'Error updating property analytic: Can\'t find propertyAnalytic']);
        }
      }
      catch (ValidationException $e) {
          return redirect()->back()
              ->withErrors(['analyticUpdateErrorMessage' => $e->validator->getMessageBag()]);
      }
      catch (Exception $e) {
          return redirect()->back()
              ->withErrors(['analyticUpdateErrorMessage' => $e->getMessage()]);
      }
    }
}
