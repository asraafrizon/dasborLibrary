<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';
    protected $fillable = [
    	'aktivitas', 'tahun', 'data_layanan'
    ];
}
