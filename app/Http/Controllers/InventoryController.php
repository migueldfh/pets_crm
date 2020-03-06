<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Product;
use App\Subsidiary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InventoryController extends Controller
{
    public function postSubsidiaryProduct($id, Request $request)
    {
      $product = Product::find($request->product);

      $inventory = Inventory::create([
        'name'  => $product->name,
        'subsidiary_id' => $id,
        'cost' => $request->price,
        'quantity' => $request->quantity,
        'operative_costs' => $request->percentage,
        'selling_price' => $request->buying_clients,
        'supplier_selling_price' => $request->buying_supplier,
        'code' => $request->cod
      ]);

      return response()->json(
          [
              'status' => 'success'
          ], Response::HTTP_OK);
    }

    public function getSubsidiaryInventory($id)
    {
        $inventories = Subsidiary::find($id)->inventories;

        return response()->json(
            [
                'status' => 'success',
                'inventories' => $inventories
            ], Response::HTTP_OK);
    }
}
