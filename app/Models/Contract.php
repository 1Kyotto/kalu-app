<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employed;

class Contract extends Model
{
    protected $table = 'contracts';
    protected $fillable = ['pdf_url'];

    public function employed()
    {
        return $this->belongsTo(Employed::class, 'contracts_id');
    }
}
