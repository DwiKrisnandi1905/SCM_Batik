<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Craftsman extends Model
{
    protected $table = 'craftsmen';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'factory_id', 'production_details', 'finished_quantity', 'completion_date', 'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class, 'factory_id');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class, 'craftsman_id');
    }

    public function distributions()
    {
        return $this->hasMany(Distribution::class, 'craftsman_id');
    }

    public function monitoring()
    {
        return $this->hasOne(Monitoring::class, 'craftsman_id');
    }
}
