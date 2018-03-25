<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = [
        'type',
        'link',
        'game_id',
        'title',
        'contents',
        'player_id'
    ];
}
