<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prasenceDetail extends Model
{
    protected $fillable = [
        'prasence_id',
        'name',
        'jabatan',
        'asal_instansi',
        'tanda_tangan'
    ];

    public function prasence(){
        return $this->belongsTo(Prasence::class,'prasence_id');
    }
}
