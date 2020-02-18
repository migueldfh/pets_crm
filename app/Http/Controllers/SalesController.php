<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subsidiary;
use App\Sale;
use Illuminate\Http\Response;

class SalesController extends Controller
{
  public function getSubsidiarySale($id)
  {
    $sales = Subsidiary::find($id)->sales;

    return response()->json(
        [
            'status' => 'success',
            'sales' => $sales
        ], Response::HTTP_OK);
  }

  public function addSale(Request $request)
  {
    // code...
  }
}
