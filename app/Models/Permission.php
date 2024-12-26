<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employed;

class Permission extends Model
{
    protected $table = 'permission';
    public $timestamps = false;
    
    protected $fillable = [
        'employees_id',
        'permission_type',
        'request_date',
        'start_date',
        'end_date',
        'status',
        'reason'
    ];

    protected $casts = [
        'request_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employed::class, 'employees_id');
    }
}
