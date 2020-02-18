<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Country;
use App\State;
use App\City;

class StateController extends Controller
{
    public function getCountries()
    {
      $countries = Country::all();

      return response()->json(
          [
              'status' => 'success',
              'countries' => $countries
          ], Response::HTTP_OK);
    }

    public function getStates($id)
    {
      $states = State::where('country_id', $id)->get();

      return response()->json(
          [
              'status' => 'success',
              'states' => $states
          ], Response::HTTP_OK);
    }

    public function getCities($id)
    {
      $cities = City::all();

      return response()->json(
          [
              'status' => 'success',
              'cities' => $cities
          ], Response::HTTP_OK);
    }
}
