<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repostero extends Model
{
    protected $table = 'Repostero'; 
    protected $primaryKey = 'emp_id';
    public $incrementing = false;
    protected $fillable = ['emp_id', 'rep_especialidad'];
    public $timestamps = false;

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'emp_id', 'emp_id');
    }
}
