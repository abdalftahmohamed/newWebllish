<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificationcreate extends Model
{
    use HasFactory;
    protected $guarded=[];
//    public $timestamps = false;
    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
