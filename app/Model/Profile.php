<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
      'user_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
