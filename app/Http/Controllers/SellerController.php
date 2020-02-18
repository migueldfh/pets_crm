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
}
