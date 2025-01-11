<?php
namespace App\Repositories;

use App\Models\GuideCategory;

class GuideCategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new GuideCategory());
    }
}