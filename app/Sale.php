<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Seller;
use App\Client;
use App\Subsidiary;
use App\Pet;

class Sale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'folio', 'client_id', 'seller_id', 'subsidiary_id', 'pet_id', 'currency',
        'conditions', 'pickup', 'shift', 'code', 'quantity', 'products', 'discount',
        'subtotal', 'total', 'status'
    ];

    protected $appends  = ['client', 'subsidiary', 'seller', 'pet'];
    /**
     * Get the post that owns the comment.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function getClientAttribute()
    {
        return Client::find($this->client_id);
    }

    public function getSellerAttribute()
    {
        return Seller::find($this->seller_id);
    }

    public function getPetAttribute()
    {
        return Pet::find($this->pet_id);
    }

    public function getSubsidiaryAttribute()
    {
        return Subsidiary::find($this->subsidiary_id);
    }
}
