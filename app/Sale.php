<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
