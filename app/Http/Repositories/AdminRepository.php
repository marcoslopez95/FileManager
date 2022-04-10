<?php

namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository;
use App\Models\User;

class AdminRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

}
