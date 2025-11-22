<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'cli_cedula';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'cli_cedula',
        'cli_nom',
        'cli_apellido',
        'cli_tel',
        'cli_dir'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'cli_cedula';
    }
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cli_cedula', 'cli_cedula');
    }
}
