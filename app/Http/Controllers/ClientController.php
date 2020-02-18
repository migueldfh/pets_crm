<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Client;
use App\Subsidiary;

class ClientController extends Controller
{
    public function getSubsidiaryClient($id)
    {
      $clients = Subsidiary::find($id)->clients;

      return response()->json(
          [
              'status' => 'success',
              'clients' => $clients
          ], Response::HTTP_OK);
    }

    public function addClient(Request $request)
    {
      $client = Client::create([
        'seller_id' => $request->input('seller_id'),
        'subsidiary_id' => $request->input('subsidiary_id'),
        'type' => $request->input('type'),
        'person_type' => $request->input('person_type'),
        'category' => $request->input('category'),
        'name' => $request->input('name'),
        'rfc' => $request->input('rfc'),
        'street' => $request->input('street'),
        'ext_number' => $request->input('ext_number'),
        'neighborhood' => $request->input('neighborhood'),
        'city' => $request->input('city'),
        'state' => $request->input('state'),
        'zipcode' => $request->input('zipcode'),
        'country' => $request->input('country'),
        'currency' => $request->input('currency'),
        'photo' => $request->input('photo'),
        'owner' => $request->input('owner'),
        'vet' => $request->input('vet'),
        'admon' => $request->input('admon'),
        'discount' => $request->input('discount'),
        'credit' => $request->input('credit'),
        'max_days_credit' => $request->input('max_days_credit'),
        'credit_limit' => $request->input('credit_limit'),
        'max_credit_limit' => $request->input('max_credit_limit'),
        'account_holder' => $request->input('account_holder'),
        'account_number' => $request->input('account_number'),
        'bank_name' => $request->input('bank_name')
      ]);

      if (!$client) {
        return response()->json(Response::HTTP_BAD_REQUEST);
      }

      return response()->json(
          [
              'status' => 'success',
              'client' => $client
          ], Response::HTTP_OK);
    }
}
