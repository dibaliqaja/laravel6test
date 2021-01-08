<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $fillable = ['name', 'age', 'phone_number', 'email', 'major_id'];

    public function major()
    {
        return $this->belongsTo('App\Major');
    }
}
