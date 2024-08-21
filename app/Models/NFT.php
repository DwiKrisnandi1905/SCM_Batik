<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NFT extends Model
{
    protected $table = 'nft_config';

    protected $primaryKey = 'id';

    protected $fillable = [
        'fromAddress',
        'contractAddress',
        'abi'
    ];
}
