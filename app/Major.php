<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = ['title', 'major'];

    public function student()
    {
        return $this->hasOne('App\Student');
    }
}
