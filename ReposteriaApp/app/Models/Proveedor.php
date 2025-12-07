<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'prov_id';
    public $incrementing = true; 
    public $timestamps = false; 

    protected $fillable = [
        'prov_nom',
        'prov_tel',
        'prov_dir',
    ];
}
