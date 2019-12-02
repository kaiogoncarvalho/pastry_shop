<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'client_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function pastries()
    {
        return $this->belongsToMany('App\Models\Pastry','orders_pastries');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

}
