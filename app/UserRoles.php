<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = ['name'];

   
}
