<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employed;

class Evaluation extends Model
{
    protected $table = 'evaluations';
    protected $fillable = ['evaluation_date', 'comments', 'score'];
    public $timestamps = false;

    public function employed()
    {
        return $this->belongsTo(Employed::class, 'employees_id');
    }
}
