<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'Pedido';
    protected $primaryKey = 'ped_id';
    public $incrementing = true;
    protected $fillable = [
        'cli_cedula',
        'emp_id',
        'ped_fec',
        'ped_hora',
        'ped_est',
        'ped_total',
    ];
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cli_cedula', 'cli_cedula');
    }

    public function domiciliario()
    {
        return $this->belongsTo(Domiciliario::class, 'dom_cedula', 'dom_cedula');
    }

    public function cajero()
    {
        return $this->belongsTo(Cajero::class, 'emp_id', 'emp_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'ped_id', 'ped_id');
    }
}
