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
    $sale = Sale::create([
      'client_id' => $request->client,
      'subsidiary_id' => $request->subsidiary,
      'pet_id' => $request->pet,
      'seller_id' => $request->seller,
      'total' => $request->total,
      'quantity' => $request->quantity,
      'products' => json_encode($request->products),
      'folio' => $request->folio,
      'total' => $request->total,
      'currency' => 'MXN',
      'status' => 'Abierto',
      'conditions' => NULL
    ]);

    $sales = Subsidiary::find($request->subsidiary)->sales;

    return response()->json(
        [
            'status' => 'success',
            'sales' => $sales
        ], Response::HTTP_OK);
  }
}
