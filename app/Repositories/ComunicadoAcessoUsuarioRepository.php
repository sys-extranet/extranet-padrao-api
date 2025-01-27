<?php

namespace App\Repositories;

use App\Models\ComunicadoAcessoUsuario;

class ComunicadoAcessoUsuarioRepository extends BaseRepository
{
  public function __construct()
  {
    parent::__construct(new ComunicadoAcessoUsuario());
  }
}