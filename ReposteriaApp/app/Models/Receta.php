<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $table = 'Receta';
    protected $primaryKey = 'rec_id';
    public $incrementing = true;
    protected $fillable = ['rec_nom'];
    public $timestamps = false;
}
