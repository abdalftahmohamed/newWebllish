<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveYoutube extends Model
{
    use HasFactory;
    protected $fillable = [

        'description',
        'link',
    ];
}
