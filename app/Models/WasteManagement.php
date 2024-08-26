<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteManagement extends Model
{
    protected $table = 'waste_management';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'waste_type',
        'management_method',
        'management_results',
        'image',
        'craftsman_id',
        'is_ref',
        'nft_token_id',
        'monitoring_id',
        'qrcode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function monitoring()
    {
        return $this->hasOne(Monitoring::class, 'waste_id');
    }
}
