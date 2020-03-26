<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'seller_id', 'subsidiary_id', 'type', 'person_type', 'category','name','rfc','street','ext_number',
      'neighborhood','city','state','zipcode','country','currency','photo','owner','vet',
      'admon','discount','credit','max_days_credit','credit_limit','max_credit_limit',
      'account_holder','account_number','bank_name', 'telvet', 'responsable'
    ];
}
