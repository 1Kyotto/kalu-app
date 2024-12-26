<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employees_id',
        'file_url',
        'period',
        'amount',
        'issue_date'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function employee()
    {
        return $this->belongsTo(Employed::class, 'employees_id');
    }
}
