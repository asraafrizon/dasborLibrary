<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    protected $table = 'inventoris';
    protected $fillable = [
    	'tahun', 'fakultas', 'data_judul', 'data_eksemplar'
    ];
}
