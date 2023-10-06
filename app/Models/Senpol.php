<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Senpol extends Model
{
    use HasFactory;
    protected $fillable = [
        'month_id',
        'comment',
        'reached',
        'target',
    ];
}
