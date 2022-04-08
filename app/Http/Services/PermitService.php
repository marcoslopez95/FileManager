<?php

namespace App\Http\Services;

use App\Http\Repositories\PermitRepository;
use App\Http\Services\BaseService;

class PermitService extends BaseService
{
    public function __construct(PermitRepository $permit)
    {
        parent::__construct($permit);
    }
}