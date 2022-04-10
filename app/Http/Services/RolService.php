<?php

namespace App\Http\Services;

use App\Http\Repositories\RolRepository;
use App\Http\Services\BaseService;

class RolService extends BaseService
{
    public function __construct(RolRepository $permit)
    {
        parent::__construct($permit);
    }
}
