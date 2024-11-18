<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    protected $fillable = ['name'];

    public function routes()
    {
        return $this->belongsToMany(Route::class)->withPivot('order');
    }
}
