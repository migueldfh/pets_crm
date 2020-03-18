<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subsidiary;
use App\Price;
use Illuminate\Http\Response;

class PriceController extends Controller {
    public function getSubsidiaryPrices($id, $type) {
      $prices = Subsidiary::find($id)->prices;

      $prices = $prices->where('type_client', $type);

      return response()->json(
          [
              'status' => 'success',
              'prices' => $prices
          ], Response::HTTP_OK);
    }

    public function getWeightPrices($id) {
      $weight = null;
      if ($id == "SC05") {
        $weight = "0-5kg";
      }elseif ($id == "SC610") {
        $weight = "6-10kg";
      }
      $price = Price::where('weight', $weight)->first();

      return response()->json(
          [
              'status' => 'success',
              'price' => $price
          ], Response::HTTP_OK);
    }
}
