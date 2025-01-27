<?php

namespace App\Repositories;

use App\Models\ComunicadoAcessoUnidade;

class ComunicadoAcessoUnidadeRepository extends BaseRepository
{
  public function __construct()
  {
    parent::__construct(new ComunicadoAcessoUnidade());
  }
}