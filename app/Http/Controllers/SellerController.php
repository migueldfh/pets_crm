<?php

namespace App\Http\Controllers;

use App\Seller;
use App\Subsidiary;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function getSubsidiarySellers($id)
    {
      $sellers = Subsidiary::find($id)->sellers;

      return response()->json(
          [
              'status' => 'success',
              'sellers' => $sellers
          ], Response::HTTP_OK);
    }

    public function addSeller(Request $request)
    {
      $seller = Seller::create([
        'subsidiary_id' => $request->input('subsidiary'),
        'name' => $request->input('name'),
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'address' => $request->input('address'),
        'rfc' => $request->input('rfc'),
        'account' => $request->input('account'),
        'personal_email' => $request->input('personal_email'),
        'office_email' => $request->input('office_email'),
        'cellphone' => $request->input('cellphone'),
        'shift' => $request->input('shift')
      ]);

      if (!$seller) {
        return response()->json(Response::HTTP_BAD_REQUEST);
      }

      return response()->json(
          [
              'status' => 'success',
              'seller' => $seller
          ], Response::HTTP_OK);
    }
}
