<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class songs extends Model
{
    //
    protected $fillable = [
        'title',
        'artist',
        'file',
        'type',
    ];
}
