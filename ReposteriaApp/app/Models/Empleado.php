<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'Empleado'; // Explicitly define the table name
    protected $primaryKey = 'emp_id';
    public $incrementing = false;
    protected $fillable = ['emp_id', 'emp_nom', 'emp_tel'];
    public $timestamps = false;
}
