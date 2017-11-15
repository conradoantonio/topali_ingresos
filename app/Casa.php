<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Casa extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'casas';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = ['folio_casa', 'coto_id', 'subcoto_id', 'users_id', 'status', 'direccion','calle_manzana','created_at'];
}
