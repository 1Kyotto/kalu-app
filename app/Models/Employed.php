<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Position;
use App\Models\User;
use App\Models\Contract;
use App\Models\Permission;
use App\Models\Attendance;
use App\Models\Evaluation;

class Employed extends Model
{
    protected $table = 'employees';
    protected $fillable = [
        'users_id',
        'positions_id',
        'entry_date',
        'status'
    ];
    public $timestamps = false;

    public function position()
    {
        return $this->belongsTo(Position::class, 'positions_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class, 'employees_id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'employees_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employees_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'employees_id');
    }
}
