<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    protected $table = 'harvests';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'material_type', 'quantity', 'quality', 'delivery_info', 'delivery_date', 'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function factories()
    {
        return $this->hasMany(Factory::class, 'harvest_id');
    }

    public function monitoring()
    {
        return $this->hasOne(Monitoring::class, 'harvest_id');
    }
}
