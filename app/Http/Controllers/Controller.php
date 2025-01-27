<?php

namespace App\Http\Controllers;

use App\Repositories\MenuRepository;
use Illuminate\Support\Facades\Route;

abstract class Controller
{
    protected $menu;

    public function __construct(MenuRepository $menuRepository)
    {
        $routeName = Route::currentRouteName();

        if ($routeName) {
            $this->menu = $menuRepository->findByColumnFirst('route', $routeName, [], ['name', 'description']);
        }

        if (!$this->menu) {
            $this->menu = (object) [
                'name' => 'Default Menu',
                'description' => 'Descrição padrão para rotas sem menu',
            ];
        }
    }
}
