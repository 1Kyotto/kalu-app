<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employed;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $fillable = ['arrival', 'departure', 'comments'];

    public function employed()
    {
        return $this->belongsTo(Employed::class);
    }
}
