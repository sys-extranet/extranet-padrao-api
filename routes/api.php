<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ComunicadoController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\GuideCategoryController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StatusTaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/teste', function () {
    return response()->json(['message' => 'Hello World!']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/images/{arquivo}', function ($imagem) {
    $path = storage_path("app/images/$imagem");
    // Verificando se o arquivo existe
    if (!file_exists($path)) {
        abort(404);
    }
    // Retornando a imagem com o tipo MIME correto
    $mime = mime_content_type($path);
    return response()->file($path, ['Content-Type' => $mime]);
});



Route::get('/comunicados/anexos/{arquivo}', function ($imagem) {
    $path = storage_path("app/comunicados/anexos/$imagem");
    // Verificando se o arquivo existe
    if (!file_exists($path)) {
        abort(404);
    }
    // Retornando a imagem com o tipo MIME correto
    $mime = mime_content_type($path);
    return response()->file($path, ['Content-Type' => $mime]);
});

Route::middleware(['auth:api'])->group(function() {
    Route::apiResources([
        'tasks' => TaskController::class,
        'unidades' => UnidadeController::class,
        'departaments' => DepartamentController::class,
        'menus' => MenuController::class,
        'guides-categories' => GuideCategoryController::class,
    ]);

    Route::prefix('/guides')->group(function() {
        Route::get('/', [GuideController::class, 'index'])->name('manuais');
        Route::get('/{id}', [GuideController::class, 'show']);
        Route::post('/', [GuideController::class, 'store']);
        Route::post('/{id}', [GuideController::class, 'update']);
        Route::delete('/{id}', [GuideController::class, 'destroy']);
    });
    
    Route::prefix('/comunicados')->group(function () {
        Route::get('/', [ComunicadoController::class, 'index'])->name('comunicados');
        Route::get('/filter', [ComunicadoController::class, 'filterComunicado'])->name('comunicados');
        Route::get('/{id}', [ComunicadoController::class, 'show']);
        Route::post('/', [ComunicadoController::class, 'store']);
        Route::post('/{id}', [ComunicadoController::class, 'update']);
        Route::get('/download/{file}', [ComunicadoController::class, 'download'])->name('api.comunicados.download');
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/{id}', [UserController::class, 'update']);
    });

    Route::prefix('/status')->group(function () {
        Route::get('/', [StatusTaskController::class, 'index']);
    });
});