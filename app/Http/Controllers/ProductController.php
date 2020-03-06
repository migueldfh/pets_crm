<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Subsidiary;
use App\Product;
use App\Service;
use App\Accesory;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::all();

        return response()->json(
            [
                'status' => 'success',
                'products' => $products
            ], Response::HTTP_OK);
    }

    public function getServices()
    {
        $services = Service::all();

        return response()->json(
            [
                'status' => 'success',
                'services' => $services
            ], Response::HTTP_OK);
    }

    public function getAccesories()
    {
        $accesories = Accesory::all();

        return response()->json(
            [
                'status' => 'success',
                'accesories' => $accesories
            ], Response::HTTP_OK);
    }

    public function getAccesoryPack()
    {
        $accesories = Accesory::findMany([2, 4, 15, 17, 18, 19]);

        return response()->json(
            [
                'status' => 'success',
                'accesoriesPack' => $accesories
            ], Response::HTTP_OK);
    }

    public function editProduct(Request $request)
    {
      $product = Product::find($request->product);

      $product->buying_price = $request->price;
      $product->quantity = $request->quantity;
      $product->save();

      $products = Product::all();
      return response()->json(
          [
              'status' => 'success',
              'products' => $products
          ], Response::HTTP_OK);
    }
}
