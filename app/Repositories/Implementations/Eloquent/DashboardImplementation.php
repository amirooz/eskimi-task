<?php

namespace App\Repositories\Implementations\Eloquent;

use App\Repositories\Contracts\DashboardRepository;
use App\Models\Task;
use App\Traits\Eloquent\Traits;

class DashboardImplementation implements DashboardRepository
{
    use Traits;

    /**
     * @var $model
     */
    private $model;

    /**
     * SysUserImplementation constructor.
     *
     * @param App\Task $model
     */
    public function __construct(Task $model)
    {
        $this->model = $model;
    }
}
