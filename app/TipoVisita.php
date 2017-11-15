<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVisita extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'tipo_visita';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = ['tipo'];
}
