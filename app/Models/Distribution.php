<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $table = 'distributions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'craftsman_id',
        'destination',
        'quantity',
        'shipment_date',
        'tracking_number',
        'received_date',
        'receiver_name',
        'received_condition',
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

    public function craftsman()
    {
        return $this->belongsTo(Craftsman::class, 'craftsman_id');
    }

    public function monitoring()
    {
        return $this->hasOne(Monitoring::class, 'distribution_id');
    }
}
