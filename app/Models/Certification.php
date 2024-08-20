<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $table = 'certifications';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'craftsman_id',
        'test_results',
        'batik_type',
        'certificate_number',
        'issue_date',
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
        return $this->hasOne(Monitoring::class, 'certification_id');
    }
}
