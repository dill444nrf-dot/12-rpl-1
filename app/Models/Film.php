<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = ['judul','durasi','rating','desc','tahun_rilis','poster','sutradara','id_genre','id_aktor'];
    public $timestamps = true;

    public function genre()
    {
        return $this->belongsTo(Genre::class,'id_genre');
    }
    public function aktors()
    {
        return $this->belongsToMany(
            Aktor::class,
            'aktor_film',
            'id_film',
            'id_aktor'
        );
    }
}
