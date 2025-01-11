<?php
namespace App\Repositories;

use App\Models\UnidadeUsuario;
use App\Repositories\BaseRepository;

class UnidadeUsuarioRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new UnidadeUsuario());
    }
}