<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Awards extends Model
{
    protected $table = 'awards';
    protected $fillable = [
        'type',
        'player_id',
        'award_date'
    ];
}
