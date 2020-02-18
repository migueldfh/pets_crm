<?php

namespace App\Http\Controllers;

use App\Subsidiary;
use App\Zone;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubsidiaryController extends Controller
{
    public function getSubsidiaries()
    {
      $subsidiaries = Subsidiary::all();

      return response()->json(
          [
              'status' => 'success',
              'subsidiaries' => $subsidiaries
          ], Response::HTTP_OK);
    }

    public function addSubsidiary(Request $request)
    {
      $subsidiary = Subsidiary::create([
        'name'  => $request->input('subsidiary')
      ]);

      if (!$subsidiary) {
        return response()->json(Response::HTTP_BAD_REQUEST);
      }

      $subsidiaries = Subsidiary::all();

      return response()->json(
          [
              'status' => 'success',
              'subsidiaries' => $subsidiaries
          ], Response::HTTP_OK);
    }

    public function getZones($id)
    {
      $zones = Subsidiary::find($id)->zones;
      return response()->json(
          [
              'status' => 'success',
              'zones' => $zones
          ], Response::HTTP_OK);
    }

    public function addZone(Request $request)
    {
      $zone = Zone::create([
        'name'  => $request->input('zone'),
        'subsidiary_id' => $request->input('subsidiary')
      ]);

      if (!$zone) {
        return response()->json(Response::HTTP_BAD_REQUEST);
      }

      $zones = Subsidiary::find($zone->subsidiary_id)->zones;

      return response()->json(
          [
              'status' => 'success',
              'zones' => $zones
          ], Response::HTTP_OK);
    }

    public function getCities($id)
    {
      $cities = Zone::find($id)->cities;
      return response()->json(
          [
              'status' => 'success',
              'cities' => $cities
          ], Response::HTTP_OK);
    }

    public function addCity(Request $request)
    {
      $city = City::create([
        'name'  => $request->input('city'),
        'zone_id' => $request->input('zone')
      ]);

      if (!$city) {
        return response()->json(Response::HTTP_BAD_REQUEST);
      }

      $cities = Zone::find($city->zone_id)->cities;

      return response()->json(
          [
              'status' => 'success',
              'cities' => $cities
          ], Response::HTTP_OK);
    }

}
