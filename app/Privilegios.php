<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilegios extends Model
{
	/**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'privilegios';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = ['tipo'];
}
