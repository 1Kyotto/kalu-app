<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employed;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $fillable = ['arrival', 'departure', 'comments'];
    public $timestamps = false;

    public function employed()
    {
        return $this->belongsTo(Employed::class, 'employees_id');
    }
}
