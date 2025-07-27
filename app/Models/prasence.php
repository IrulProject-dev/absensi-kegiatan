<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prasence extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'slug',
        'tgl_kegiatan',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail(){
        return $this->hasMany(prasenceDetail::class,'prasence_id');
    }
}
