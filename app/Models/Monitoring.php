<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    protected $table = 'monitorings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'harvest_id', 'factory_id', 'craftsman_id', 'certification_id', 'waste_id', 'distribution_id', 'status', 'last_updated'
    ];

    public function harvest()
    {
        return $this->belongsTo(Harvest::class, 'harvest_id');
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class, 'factory_id');
    }

    public function craftsman()
    {
        return $this->belongsTo(Craftsman::class, 'craftsman_id');
    }

    public function certification()
    {
        return $this->belongsTo(Certification::class, 'certification_id');
    }

    public function wasteManagement()
    {
        return $this->belongsTo(WasteManagement::class, 'waste_id');
    }

    public function distribution()
    {
        return $this->belongsTo(Distribution::class, 'distribution_id');
    }
}
