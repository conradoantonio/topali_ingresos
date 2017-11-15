<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Guardia extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'guardias';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = ['coto_id', 'subcoto_id', 'users_id', 'status', 'created_at'];
}
