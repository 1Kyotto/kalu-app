<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employed;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = ['permission_type', 'request_date', 'start_date', 'end_date', 'status', 'reason'];


    public function employed()
    {
        return $this->belongsTo(Employed::class);
    }
}
