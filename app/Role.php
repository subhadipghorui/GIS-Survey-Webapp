<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['users'];
    
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
