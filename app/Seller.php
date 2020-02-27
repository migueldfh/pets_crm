<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'subsidiary_id', 'shift','first_name',
        'last_name',
        'address',
        'rfc',
        'account',
        'personal_email',
        'office_email',
        'cellphone',
    ];
}
