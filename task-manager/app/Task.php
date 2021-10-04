<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    // taskをついか
    protected $fillable = [
        'title',
        'executed'
    ];
}
