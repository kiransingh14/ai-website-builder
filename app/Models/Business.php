<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{    
    protected $table = 'businesses';

    public function website()
    {
        return $this->hasOne(Website::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
