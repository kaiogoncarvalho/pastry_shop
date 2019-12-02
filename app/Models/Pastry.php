<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pastry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'price',
        'photo',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'deleted_at',
        'pivot'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
