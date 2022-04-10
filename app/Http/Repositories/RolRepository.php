<?php

namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository;
use App\Models\Rol;

class RolRepository extends BaseRepository
{
    public function __construct(Rol $model)
    {
        parent::__construct($model);
    }
}
