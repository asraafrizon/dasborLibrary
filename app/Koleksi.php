<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    protected $table = 'koleksis';
    protected $fillable = [
    	'jurnal', 'tahun', 'jumlah'
    ];
}
