<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batik extends Model
{
    protected $table = 'batik';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];
}
