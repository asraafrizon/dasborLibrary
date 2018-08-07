<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    protected $table = 'inventoris';
    protected $fillable = [
    	'fakultas', 'data_judul', 'data_eksemplar'
    ];
}
