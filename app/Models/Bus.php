<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['name', 'route_id'];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
