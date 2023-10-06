<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveTwitter extends Model
{
    use HasFactory;
       protected $fillable = [
        'description',
        'link',
    ];
}
