<?php
namespace App\Repositories;

use App\Models\Guide;

class GuideRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Guide());
    }

    public function findGuideByCategories($categories)
    {
        return $this->model->whereIn('category_id', $categories)->get();
    }
}