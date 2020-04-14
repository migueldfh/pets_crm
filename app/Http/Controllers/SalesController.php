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

  public function getSingleSale($id)
  {
    $sale = Sale::find($id);
    $new_products = json_decode($sale->products);

    $data = [
      'pet' => $sale->pet,
      'client' => $sale->client,
      'seller' => $sale->seller,
      'products' => $new_products,
      'status' => $sale->status,
      'folio' => $sale->folio,
      'id' => $sale->id,
      'quantity' => $sale->quantity,
      'total' => $sale->total
    ];

    return response()->json(
      [
          'status' => 'success',
          'sale' => $data
      ], Response::HTTP_OK);
  }

  public function editSingleSale(Request $request)
  {
    $sale = Sale::find($request->id);

    $sale->status = $request->status;
    $sale->save();

    $sales = Subsidiary::find($request->subsidiary)->sales;

    return response()->json(
        [
            'status' => 'success',
            'sales' => $sales
        ], Response::HTTP_OK);
  }
}
