<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    public $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'birthdate',
        'address',
        'complement',
        'neighborhood',
        'postcode',
        'created_at',
        'updated_at'
    ];

    public $dates = [
        'birthdate',
        'created_at',
        'updated_at'
    ];


}
