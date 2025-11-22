<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoPresentacion extends Model
{
    protected $table = 'ProductoPresentacion'; // Explicitly define the table name
    protected $primaryKey = 'prp_id';
    public $incrementing = true;
    protected $fillable = ['pro_id', 'tam_id', 'prp_precio'];
    public $timestamps = false;

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'pro_id', 'pro_id');
    }

    public function tamano()
    {
        return $this->belongsTo(Tamano::class, 'tam_id', 'tam_id');
    }
}
