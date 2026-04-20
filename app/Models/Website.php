<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $table = 'websites';

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
