<?php

namespace App\Http\Controllers;

use App\Punch;

class PunchController extends BaseController
{
    /**
     * Create a controller instance.
     *
     * @param Punch $entity
     */
    public function __construct(Punch $entity)
    {
        parent::__construct($entity);
        $this->model = $this->entity->with('client')->orderByDesc('date')->get();
    }
}
