<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employed;

class Position extends Model
{
    protected $table = 'positions';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function employees()
    {
        return $this->hasMany(Employed::class);
    }
}
