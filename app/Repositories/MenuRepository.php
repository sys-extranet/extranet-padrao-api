<?php
namespace App\Repositories;

use App\Models\Menu;

class MenuRepository extends BaseRepository
{
    public function __construct()
    {
      parent::__construct(new Menu());
    }
}