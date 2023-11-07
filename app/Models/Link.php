<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $fillable = [
        'description_facebook',
        'name_facebook',
        'link_facebook',
        'description_youtube',
        'name_youtube',
        'link_youtube',
        'description_twitter',
        'name_twitter',
        'link_twitter',
        'description_instagram',
        'name_instagram',
        'link_instagram',
        'description_linkedin',
        'name_linkedin',
        'link_linkedin',
    ];}
