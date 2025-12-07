<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamano extends Model
{
    protected $table = 'Tamano'; 
    protected $primaryKey = 'tam_id';
    public $incrementing = true;
    protected $fillable = ['tam_nom', 'tam_porciones', 'tam_factor'];
    public $timestamps = false;
}
