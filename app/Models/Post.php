<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // fillable
    protected $fillable = ['title', 'content'];
}
