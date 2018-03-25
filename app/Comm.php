<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comm extends Model
{
    protected $table = 'comm';
    protected $fillable = ['player_id','schedule'];
}
