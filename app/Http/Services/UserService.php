<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Http\Services\BaseService;

class UserService extends BaseService
{
    public function __construct(UserRepository $permit)
    {
        parent::__construct($permit);
    }
}