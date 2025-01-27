<?php

namespace App\Services;

use App\Models\Comunicado;
use App\Repositories\ComunicadoAcessoUnidadeRepository;
use App\Repositories\ComunicadoAcessoUsuarioRepository;
use App\Repositories\ComunicadoFileRepository;
use App\Repositories\ComunicadoRepository;
use Illuminate\Support\Facades\Storage;

class ComunicadoService
{
    private $comunicadoRepository;
    private $comunicadoFileRepository;
    private $comunicadoAcessoUsuarioRepository;
    private $comunicadoAcessoUnidadeRepository;

    public function __construct(
        ComunicadoRepository $comunicadoRepository,
        ComunicadoFileRepository $comunicadoFileRepository,
        ComunicadoAcessoUsuarioRepository $comunicadoAcessoUsuarioRepository,
        ComunicadoAcessoUnidadeRepository $comunicadoAcessoUnidadeRepository
    ) {
        $this->comunicadoRepository = $comunicadoRepository;
        $this->comunicadoFileRepository = $comunicadoFileRepository;
        $this->comunicadoAcessoUsuarioRepository = $comunicadoAcessoUsuarioRepository;
        $this->comunicadoAcessoUnidadeRepository = $comunicadoAcessoUnidadeRepository;
    }

    public function getAllComunicados(int $perPage)
    {
        return $this->comunicadoRepository->getAllWithPaginate($perPage, ['remetente', 'files']);
    }

    public function filterComunicados(array $data)
    {
        return $this->comunicadoRepository->filter($data, ['remetente', 'files']);
    }

    public function createComunicado(array $data)
    {
        $comunicado = $this->comunicadoRepository->save($data);

        if (isset($data['anexos'])) {
            $this->uploadFiles($comunicado->id, $data['anexos']);
        }

        if ($data['tipo_acesso'] === 'U') {
            foreach($data['users_id'] as $userId) {
                $this->comunicadoAcessoUsuarioRepository->save([
                    'comunicado_id' => $comunicado->id,
                    'user_id' => $userId
                ]);
            }
        } elseif ($data['tipo_acesso'] === 'D') {
            foreach ($data['departament_id'] as $departamentId) {
                $this->comunicadoAcessoUnidadeRepository->save([
                    'comunicado_id' => $comunicado->id,
                    'departament_id' => (int) $departamentId
                ]);
            }
        }

        return $this->comunicadoRepository->find($comunicado->id, ['files']);
    }

    public function getComunicadoById($id)
    {
        return $this->comunicadoRepository->find($id, ['files', 'remetente']);
    }

    public function deleteComunicado(int $id)
    {
        $this->comunicadoRepository->delete($id);
    }

    private function uploadFiles(int $comunicadoId, array $files)
    {
        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $tempName = time() . '_' . $fileName;
            $pathFile = $file->storeAs('comunicados/anexos', $tempName);

            $this->comunicadoFileRepository->save([
                'comunicado_id' => $comunicadoId,
                'file_name' => $fileName,
                'temporary_file_name' => $tempName,
                'path_file' => $pathFile,
            ]);
        }
    }
}
