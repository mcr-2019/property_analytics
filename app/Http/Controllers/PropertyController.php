<?php

namespace App\Http\Controllers;

use App\Models\Property;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  { 
    try {
      $request->validate([
          'suburb' => 'required|max:255',
          'state' => 'required|max:255',
          'country' => 'required|max:255'
      ]);
      
      $guid = Str::uuid()->toString();
     
      $property = Property::create([
        'guid' => $guid,
        'suburb' => $request->suburb,
        'state' => $request->state,
        'country' => $request->country
      ]);
       
      return redirect('/')->with('propertyCreatedSuccessMessage', 'Property created successfully!');
    }
    catch (ValidationException $e) {
        return redirect()->back()
            ->withErrors(['propertyCreatedErrorMessage' => $e->validator->getMessageBag()]);
    }
    catch (Exception $e) {
        return redirect()->back()
            ->withErrors(['propertyCreatedErrorMessage' => $e->getMessage()]);
    }
  }
}
