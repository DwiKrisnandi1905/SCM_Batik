<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Craftsman extends Model
{
    protected $table = 'craftsmen';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'production_details',
        'finished_quantity',
        'completion_date',
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

    public function certifications()
    {
        return $this->hasOne(Certification::class, 'craftsman_id');
    }

    public function distributions()
    {
        return $this->hasOne(Distribution::class, 'craftsman_id');
    }

    public function monitoring()
    {
        return $this->hasOne(Monitoring::class, 'craftsman_id');
    }
}
