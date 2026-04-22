<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $table = 'websites';
    protected $fillable = ['business_id', 'website_title', 'tagline', 'about_section', 'services', 'slug'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
