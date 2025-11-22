<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'Producto'; // Explicitly define the table name
    protected $primaryKey = 'pro_id';
    public $incrementing = true;
    protected $fillable = ['pro_nom', 'rec_id'];
    public $timestamps = false;

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'rec_id', 'rec_id');
    }

    public function presentaciones()
    {
        return $this->hasMany(ProductoPresentacion::class, 'pro_id', 'pro_id');
    }
}
