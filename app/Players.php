<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    protected $table = 'players';
    protected $fillable = ['unique_id','fname','mname','lname','dob','position','jersey','height','weight','section','prof_pic','portrait_pic','status','comm_status'];
}
