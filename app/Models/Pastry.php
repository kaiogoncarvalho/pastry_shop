<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pastry extends Model
{
    use SoftDeletes;

    public $fillable = [
        'id',
        'name',
        'photo',
    ];
}
