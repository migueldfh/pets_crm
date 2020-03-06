<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Inventory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'subsidiary_id', 'cost', 'quantity', 'operative_costs', 'selling_price', 'supplier_selling_price',
        'other_selling_price', 'code'
    ];

    protected $appends  = ['general_quantity'];

    public function getGeneralQuantityAttribute()
    {
      $product = Product::where('code', $this->code)->first();

      return $product->quantity;
    }
}
