<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Pet;

class PetController extends Controller
{
    public function addPet(Request $request)
    {
      $pet = Pet::create([
        'subsidiary_id' => $request->input('subsidiary'),
        'client_id' => $request->input('client'),
        'name' => $request->input('name'),
        'kind' => $request->input('kind'),
        'genus' => $request->input('genus'),
        'weight' => $request->input('weight'),
        'birth' => $request->input('birth'),
        'death' => $request->input('death'),
        'owner' => $request->input('owner')
      ]);

      if (!$pet) {
        return response()->json(Response::HTTP_BAD_REQUEST);
      }

      return response()->json(
          [
              'status' => 'success',
              'pet' => $pet
          ], Response::HTTP_OK);
    }
}
