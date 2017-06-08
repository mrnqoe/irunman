<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Category extends Model
{
    protected $fillable = ['id', 'title', 'url'];
}
