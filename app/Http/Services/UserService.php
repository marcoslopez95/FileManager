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

    public function ArchivosUsuario($user){
        $user = $this->repository->show(($user));
        $user->load('Files.File');
        return $user;
    }
}
