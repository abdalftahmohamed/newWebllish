<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUpPages extends Model
{
    use HasFactory;
    protected $fillable = [
        'facebook',
        'youtube',
        'instagram',
        'twitter',
        'linkedin',

    ];
}
