<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'prov_id';
    public $incrementing = true; // prov_id is AUTO_INCREMENT
    public $timestamps = false; // Assuming no created_at/updated_at columns in 'proveedor' table

    protected $fillable = [
        'prov_nom',
        'prov_tel',
        'prov_dir',
    ];
}
