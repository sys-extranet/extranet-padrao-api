<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComunicadoAcessoUsuario extends Model
{
    use HasFactory;

    protected $table = 'comunicados_acesso_usuarios';

    protected $fillable = [
        'comunicado_id',
        'user_id'
    ];
}
