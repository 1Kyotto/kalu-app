<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employed;

class Contract extends Model
{
    protected $table = 'contracts';
    protected $fillable = ['employees_id', 'pdf_url'];

    public function employed()
    {
        return $this->belongsTo(Employed::class, 'employees_id');
    }
}
