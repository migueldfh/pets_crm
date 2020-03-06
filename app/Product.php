<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $appends  = ['subsidiary_quantity', 'percentage', 'price_clients',
    'price_supplier'];

    public function getSubsidiaryQuantityAttribute()
    {
    }

    public function getPercentageAttribute()
    {
    }

    public function getPriceClientsAttribute()
    {
    }

    public function getPriceSupplierAttribute()
    {
    }
}
