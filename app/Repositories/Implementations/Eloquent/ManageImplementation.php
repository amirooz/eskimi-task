<?php

namespace App\Repositories\Implementations\Eloquent;

use App\Repositories\Contracts\ManageRepository;
use App\Models\Task;
use App\Traits\Eloquent\Traits;

class ManageImplementation implements ManageRepository
{
    use Traits;

    /**
     * @var $model
     */
    private $model;

    /**
     * MsSysUserImplementation constructor.
     *
     * @param App\User $model
     */
    public function __construct(Task $model)
    {
        $this->model = $model;
    }
}
