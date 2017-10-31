<?php

namespace App\Common;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'uuid', 'message', 'createdAt'
    ];
}
