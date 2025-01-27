<?php

namespace App\Repositories;

use App\Models\Comunicado;
use App\Repositories\BaseRepository;

class ComunicadoRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Comunicado());
    }

    public function filter(array $data, array $relations = [])
    {
        $query = $this->model->query();

        if (isset($data['titulo'])) {
            $query->where('titulo', 'like', '%' . $data['titulo'] . '%');
        }

        if (isset($data['remetente'])) {
            $query->where('remetente', 'like', '%' . $data['remetente'] . '%');
        }

        if (isset($data['tipo_acesso'])) {
            $query->where('tipo_acesso', $data['tipo_acesso']);
        }

        if (isset($data['data_inicio'])) {
            $query->where('data_inicio', '>=', $data['data_inicio']);
        }

        if (isset($data['data_fim'])) {
            $query->where('data_fim', '<=', $data['data_fim']);
        }

        if ($relations) {
            return $query->with($relations)->get();
        }

        return $query->get();
    }
}