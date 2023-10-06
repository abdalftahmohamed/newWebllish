<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function performances()
    {
        return $this->hasMany(Performance::class, 'month_id');
    }
}
