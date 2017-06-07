<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Topic extends Model
{
    public $translatedAttributes = ['title'];
    protected $fillable = ['id'];
}
