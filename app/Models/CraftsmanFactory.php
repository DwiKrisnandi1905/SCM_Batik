<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CraftsmanFactory extends Model
{
    protected $table = 'craftsman_factory';
    protected $primaryKey = 'id';
    protected $fillable = [
        'craftsman_id',
        'factory_id',
    ];

}
