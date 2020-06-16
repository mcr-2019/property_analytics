<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Property Analytics</title>
 
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
 
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>

      <div class="container mt-5 text-center">
        <div class="row mt-5">
          <div class="col text-left p-3" style="border: 1px solid #ddd;">

            @if(session()->has('propertyCreatedSuccessMessage'))
              <div class="mb-3">
                <div class="alert alert-success">
                    {{ session()->get('propertyCreatedSuccessMessage') }}
                </div>
              </div>
            @endif
            @if(session()->has('propertyCreatedErrorMessage'))
              <div class="mb-3">
                <div class="alert alert-danger">
                    {{ session()->get('propertyCreatedErrorMessage') }}
                </div>
              </div>
            @endif
            
            <div class="mb-3">
              <strong>Add new property:</strong>
            </div>
            
            <form method="POST" action="/properties" class="input-group mb-3">
                @csrf

                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="suburb" placeholder="Suburb" required />
                </div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="state" placeholder="State" required />
                </div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="country" placeholder="Country" required />
                </div>
                
                <button type="submit" class="btn btn-dark">Submit</button>
                
            </form>

          </div>
          <div class="col text-left p-3" style="border: 1px solid #ddd;">

            @if(session()->has('analyticCreateSuccessMessage'))
              <div class="mb-3">
                <div class="alert alert-success">
                    {{ session()->get('analyticCreateSuccessMessage') }}
                </div>
              </div>
            @endif
            @if(session()->has('analyticCreateErrorMessage'))
              <div class="mb-3">
                <div class="alert alert-danger">
                    {{ session()->get('analyticCreateErrorMessage') }}
                </div>
              </div>
            @endif
             
            @if (count($properties) > 0)
            
              <div class="mb-3">
                <strong>Add new analytic value:</strong>
              </div>
              <form method="POST" action="/analytics">
                  @csrf
                  
                  <div class="form-group mb-3">
                    <label for="propertySelection">Select property:</label>
                    <select class="form-control" id="propertySelection" name="property_id">
                      @foreach ($properties as $property)
                        <option value="{{ $property->id }}">{{ $property->id }}: {{ $property->suburb }}/{{ $property->state }}/{{ $property->country }}</option>
                      @endforeach
                    </select>
                  </div>
                  
                  <div class="form-group mb-3">
                    <label for="analyticTypeSelection">Select analytic type:</label>
                    <select class="form-control" id="analyticTypeSelection" name="analytic_type_id">
                      @foreach ($analyticTypes as $analyticType)
                        <option value="{{ $analyticType->id }}">{{ $analyticType->name }}</option>
                      @endforeach
                    </select>
                  </div>
                   
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="value" placeholder="Value (numeric)" required />
                  </div>
                   
                  <button type="submit" class="btn btn-success">Submit</button>

              </form>
              
            @endif
              
          </div>
        </div>
        <div class="row mt-5 mb-5">
          <div class="col text-left p-3" ng-app="propertyAnalyticsApp" ng-controller="PropertyAnalyticsAppController" style="border: 1px solid #ddd;">
            
            <div ng-cloak>
              @if(session()->has('analyticUpdateSuccessMessage'))
                <div class="mb-3">
                  <div class="alert alert-success">
                      {{ session()->get('analyticUpdateSuccessMessage') }}
                  </div>
                </div>
              @endif
              @if(session()->has('analyticUpdateErrorMessage'))
                <div class="mb-3">
                  <div class="alert alert-danger">
                      {{ session()->get('analyticUpdateErrorMessage') }}
                  </div>
                </div>
              @endif
               
              @if (count($propertyAnalytics) > 0)
              
                <div class="mb-3">
                  <strong>Update analytic value:</strong>
                </div>
                <form method="POST" action="@{{ '/analytics/' + propertyAnalyticValueId }}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="form-group mb-3">
                      <label for="propertyAnalyticSelection">Select property/analytic type record:</label>
                      <select class="form-control"
                              id="propertyAnalyticSelection"
                              name="property_analytic_id"
                              ng-model="selectedPropertyAnalytic"
                              ng-change="changePropertyAnalyticValue()"
                      >
                        <option value="@{{ propertyAnalyticItem.id }}"
                                ng-repeat="propertyAnalyticItem in propertyAnalytics"
                        >
                          Property: @{{ propertyAnalyticItem.property.id }}: @{{ propertyAnalyticItem.property.suburb }}/@{{ propertyAnalyticItem.property.state }}/@{{ propertyAnalyticItem.property.country }} || Analytic Type: @{{ propertyAnalyticItem.analytic_type.name }}
                        </option>
                      </select>
                    </div>
                     
                    <div class="input-group mb-3">
                      <input type="text"
                              class="form-control"
                              value="@{{ propertyAnalyticValue }}"
                              name="value" 
                              placeholder="Value (numeric)"
                              required
                      />
                    </div>
                     
                    <button type="submit" class="btn btn-warning">Submit</button>

                </form>
                
              @endif
               
            </div>
          </div>
          <div class="col p-3 text-left" style="border: 1px solid #ddd;">
             
            @if(session()->has('propertyAnalyticsInfoMessage'))
              <div class="mb-3">
                <div class="alert alert-success">
                  {{ session()->get('propertyAnalyticsInfoMessage') }}
                </div>
              </div>
            @endif
            @if(session()->has('propertyAnalyticsErrorMessage'))
              <div class="mb-3">
                <div class="alert alert-danger">
                    {{ session()->get('propertyAnalyticsErrorMessage') }}
                </div>
              </div>
            @endif

            @if (count($suburbs) > 0)
              
              <div class="mb-3">
                <strong>Get a summary of property analytics for a suburb:</strong>
              </div>
              
              <form method="POST" action="/property_analytics" class="mb-3">
                @csrf
                
                <div class="form-group mb-3">
                  <label for="suburbSelection">Select suburb:</label>
                  <select class="form-control"
                          id="suburbSelection"
                          name="suburb_title"
                  >
                    @foreach ($suburbs as $suburb)
                      <option value="{{ $suburb }}">
                        {{ $suburb }}
                      </option>
                    @endforeach
                  </select>
                </div> 

                <button type="submit" class="btn btn-info">Submit</button>

              </form>
             
            @endif

            @if (count($states) > 0)

              <div class="mb-3">
                <strong>Get a summary of property analytics for a state:</strong>
              </div>
              
              <form method="POST" action="/property_analytics" class="mb-3">
                @csrf
                
                <div class="form-group mb-3">
                  <label for="stateSelection">Select state:</label>
                  <select class="form-control"
                          id="stateSelection"
                          name="state_title"
                  >
                    @foreach ($states as $state)
                      <option value="{{ $state }}">
                        {{ $state }}
                      </option>
                    @endforeach
                  </select>
                </div> 

                <button type="submit" class="btn btn-info">Submit</button>

              </form>
             
            @endif

            @if (count($countries) > 0)

              <div class="mb-3">
                <strong>Get a summary of property analytics for a country:</strong>
              </div>
              
              <form method="POST" action="/property_analytics" class="mb-3">
                @csrf
                
                <div class="form-group mb-3">
                  <label for="countrySelection">Select country:</label>
                  <select class="form-control"
                          id="countrySelection"
                          name="country_title"
                  >
                    @foreach ($suburbs as $country)
                      <option value="{{ $country }}">
                        {{ $country }}
                      </option>
                    @endforeach
                  </select>
                </div> 

                <button type="submit" class="btn btn-info">Submit</button>

              </form>
             
            @endif
           
          </div>
        </div>
      </div>
      
    <style>
      [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
        display: none !important;
      }
    </style>
  	<script type="text/javascript" src="{{ url('js/angular-1.7.9.min.js') }}"></script> 
    <script>
      
      var propertyAnalyticsApp = angular.module('propertyAnalyticsApp', [], function($interpolateProvider){
          $interpolateProvider.startSymbol('@{{');
          $interpolateProvider.endSymbol('}}');
      });
       
      propertyAnalyticsApp.controller('PropertyAnalyticsAppController', function PropertyAnalyticsAppController($scope, $filter) {
        
        // In real website this will be retrieved via API
        var propertyAnalyticsJson = "{{ json_encode($propertyAnalytics, JSON_UNESCAPED_UNICODE) }}";
        propertyAnalyticsJson = propertyAnalyticsJson.replace(/&quot;/g, '\"');
        
  			$scope.propertyAnalytics = JSON.parse(propertyAnalyticsJson);
        $scope.propertyAnalyticValueId = 0;
         
        $scope.changePropertyAnalyticValue = function() {
          $scope.selectedItem = $filter('filter')($scope.propertyAnalytics, $scope.selectedPropertyAnalytic)[0];
          
          $scope.propertyAnalyticValue = $scope.selectedItem.value;
          $scope.propertyAnalyticValueId = $scope.selectedItem.id;
        }
      });

    </script>
    </body>
</html>
