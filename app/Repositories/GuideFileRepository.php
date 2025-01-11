<?php
namespace App\Repositories;

use App\Models\GuideFile;

class GuideFileRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new GuideFile());
    }
}