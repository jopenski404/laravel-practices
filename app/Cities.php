<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = ['name'];
}
