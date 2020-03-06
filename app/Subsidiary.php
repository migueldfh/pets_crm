<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'location',
    ];

    public function zones()
    {
        return $this->hasMany('App\Zone');
    }

    public function sales()
    {
        return $this->hasMany('App\Sale');
    }

    public function clients()
    {
        return $this->hasMany('App\Client');
    }

    public function pets()
    {
        return $this->hasMany('App\Pet');
    }

    public function sellers()
    {
        return $this->hasMany('App\Seller');
    }

    public function inventories()
    {
        return $this->hasMany('App\Inventory');
    }
}
