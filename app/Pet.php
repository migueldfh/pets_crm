<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'subsidiary_id', 'client_id', 'weight', 'kind', 'genus', 'birth',
        'death', 'owner'
    ];
}
