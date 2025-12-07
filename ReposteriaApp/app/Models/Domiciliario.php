<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domiciliario extends Model
{
    protected $table = 'Domiciliario'; 
    protected $primaryKey = 'emp_id';
    public $incrementing = false;
    protected $fillable = ['emp_id', 'dom_medTrans'];
    public $timestamps = false;

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'emp_id', 'emp_id');
    }
}
