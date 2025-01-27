<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComunicadoRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Comunicado;
use App\Repositories\ComunicadoAcessoUnidadeRepository;
use App\Repositories\ComunicadoAcessoUsuarioRepository;
use App\Repositories\ComunicadoFileRepository;
use App\Repositories\ComunicadoRepository;
use App\Repositories\MenuRepository;
use App\Services\ComunicadoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ComunicadoController extends Controller
{
    private $comunicadoRepository;
    private $comunicadoService;

    public function __construct(
        MenuRepository $menuRepository,
        ComunicadoService $comunicadoService
    )
    {
        parent::__construct($menuRepository);
        $this->comunicadoService = $comunicadoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $comunicados = $this->comunicadoService->getAllComunicados(10);
            $response = new ApiResponse(Response::HTTP_OK, 'Listagem de comunicados realizada.', $this->menu);
            return $response->toResponse($comunicados);
        } catch (\Exception $e) {
            $response = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $response->toResponse([]);
        }
    }

    public function filterComunicado(ComunicadoRequest $request)
    {
        try {
            $comunicados = $this->comunicadoService->filterComunicados($request->all());
            $response = new ApiResponse(Response::HTTP_OK, 'Listagem de comunicados realizada.', $this->menu);
            return $response->toResponse($comunicados);
        } catch (\Exception $e) {
            $response = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $response->toResponse([]);
        }
    }

    /**
     * @param ComunicadoRequest $request
     * @return JsonResponse|Response
     */
    public function store(ComunicadoRequest $request)
    {
        try {
            $comunicadoCreated = $this->comunicadoService->createComunicado($request->all());
            $response = new ApiResponse(Response::HTTP_OK, 'Comunicado cadastrado com sucesso.');
            return $response->toResponse($comunicadoCreated);
        } catch (\Exception $e) {
            $response = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $response->toResponse([]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $comunicado = $this->comunicadoService->getComunicadoById($id);
            $response = new ApiResponse(Response::HTTP_OK, 'Comunicado listado com sucesso.');
            return $response->toResponse($comunicado);
        } catch (\Exception $e) {
            $response = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $response->toResponse([]);
        }
    }

    public function download($file)
    {
        if ($file) {
            return response()->download(storage_path('app/comunicados/anexos/'.$file));
        }
        return response()->json(['message' => 'File not found.'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ComunicadoRequest $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $comunicado = $this->comunicadoService->deleteComunicado($id);
            $response = new ApiResponse(Response::HTTP_OK, 'Comunicado removido com sucesso.');
            return $response->toResponse($comunicado);
        } catch (\Exception $e) {
            $response = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $response->toResponse([]);
        }
    }
}
