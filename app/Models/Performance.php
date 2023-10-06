<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;
    protected $fillable = [
        'sympol',
        'target',
        'reached',
        'comment',
        'month_id',
    ];

    public function months()
    {
        return $this->belongsTo(Month::class, 'month_id', 'id');
    }
}
