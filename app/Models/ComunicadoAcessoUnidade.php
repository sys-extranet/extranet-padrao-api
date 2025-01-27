<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComunicadoAcessoUnidade extends Model
{
    use HasFactory;

    protected $table = 'comunicados_acesso_unidades';

    protected $fillable = [
        'comunicado_id',
        'unidade_id'
    ];
}
