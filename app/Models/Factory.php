<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    protected $table = 'factories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'harvest_id',
        'received_date',
        'initial_process',
        'semi_finished_quantity',
        'semi_finished_quality',
        'factory_name',
        'factory_address',
        'image',
        'is_ref',
        'nft_token_id',
        'monitoring_id',
        'qrcode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function harvest()
    {
        return $this->belongsTo(Harvest::class, 'harvest_id');
    }

    public function craftsman()
    {
        return $this->hasOne(Craftsman::class, 'factory_id');
    }

    public function monitoring()
    {
        return $this->hasOne(Monitoring::class, 'factory_id');
    }
}
