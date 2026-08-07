<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aktor extends Model
{
    protected $fillable = 
    [
        'nama_aktor',
        'gender',
        'umur',
        'foto'
     ];
    public $timestamps = true;  

    public function films()
    {
        return $this->belongsToMany(
            Film::class,
            'aktor_film',
            'id_aktor',
            'id_film'
        );
    }
}
