<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use App\Repositories\UnidadeUsuarioRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    private $userRepository;
    private $unidadeUsuarioRepository;

    public function __construct(UserRepository $userRepository, UnidadeUsuarioRepository $unidadeUsuarioRepository)
    {
        $this->userRepository = $userRepository;
        $this->unidadeUsuarioRepository = $unidadeUsuarioRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = $this->userRepository->all(['departament', 'unidade']);
            $res = new ApiResponse(ResponseAlias::HTTP_OK, 'Listagem de usuários realizada com sucesso!');
            return $res->toResponse($users);
        } catch (\Exception $e) {
            $res = new ApiResponse(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $res->toResponse([]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try{
            $user = $this->userRepository->find($id, ['departament', 'unidadeUsuario']);
            $res = new ApiResponse(ResponseAlias::HTTP_OK, 'Usuario encontrado com sucesso!');
            return $res->toResponse($user);

        } catch (\Exception $e) {
            $res = new ApiResponse(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $res->toResponse([]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        try { 
            $user = $this->userRepository->findOrFail($id);

            if ($request->hasFile('imagem_profile')) {
                $this->deleteExistingPhoto($user);
                $photoDetails = $this->storeNewPhoto($request->file('imagem_profile'));
                $request->merge($photoDetails);
            }

            if ($request->has('unidade_id')) {
                $unidadeUsuario = $this->unidadeUsuarioRepository->findByColumnFirst('user_id', $id);
                
                if ($unidadeUsuario) {
                    $unidadeUsuario->update(['unidade_id' => $request->unidade_id]);
                } else {
                    $this->unidadeUsuarioRepository->save(['user_id' => $id, 'unidade_id' => $request->unidade_id]);
                }
                
            }

            $user->update($request->all());
            $response = new ApiResponse(ResponseAlias::HTTP_OK, 'Usuario atualizado com sucesso!');
            $userUpdated = $this->userRepository->findOrFail($id);
            return $response->toResponse($userUpdated);
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage(), [
                'user_id' => $id,
                'request' => $request->all(),
                'exception' => $e
            ]);

            $response = new ApiResponse(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $response->toResponse([]);
        }
    }

    private function deleteExistingPhoto(User $user): void
    {
        if ($user->photo) {
            Storage::delete('images/' . $user->photo);
        }
    }

    private function storeNewPhoto($image): array
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('images', $imageName);
        $imagePath = asset("api/images/" . $imageName);

        return [
            'photo' => $imageName,
            'path_image' => $imagePath
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
