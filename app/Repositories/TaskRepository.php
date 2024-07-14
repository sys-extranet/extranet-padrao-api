<?php
namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Task());
    }
}