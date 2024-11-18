<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['name'];

    public function stops()
    {
        return $this->belongsToMany(Stop::class)->withPivot('order');
    }

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }
}
