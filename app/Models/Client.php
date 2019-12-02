<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
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

    protected $dates = [
        'birthdate',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'birthdate' => 'date:Y-m-d',
    ];

}
