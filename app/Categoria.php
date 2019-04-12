<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //ELOQUENT ASUME EL NOMBRE DE LA TABLA Y QUE TIENE UN CAMPO ID
    //protected $table = 'categorias';
    //protected $primaryKey = 'id';

    //EVITA QUE USUARIOS MALICIOSOS REALICEN PETICIONES HTTP CON PARAMETROS DE ADMINISTRADOR Y ESCALEN EN PERMISOS
    protected $fillable = ['nombre','descripcion','condicion'];
}
