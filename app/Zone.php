<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'subsidiary_id',
    ];

    public function cities()
    {
        return $this->hasMany('App\City');
    }
}
