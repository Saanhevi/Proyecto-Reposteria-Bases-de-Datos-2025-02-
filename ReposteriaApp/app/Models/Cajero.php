<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cajero extends Model
{
    protected $table = 'Cajero'; // Explicitly define the table name
    protected $primaryKey = 'emp_id';
    public $incrementing = false;
    protected $fillable = ['emp_id', 'caj_turno'];
    public $timestamps = false;

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'emp_id', 'emp_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'emp_id', 'emp_id');
    }
}
