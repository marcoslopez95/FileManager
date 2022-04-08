<?php

namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository;
use App\Models\Permit;

class PermitRepository extends BaseRepository
{
    public function __construct(Permit $permit)
    {
        parent::__construct($permit);
    }

    public function store($data)
    {
        $data['created_id'] = 0;
        $data['updated_id'] = 0;
        return parent::store($data);
    }

    public function update($id, $data)
    {
        $data['created_id'] = 0;
        $data['updated_id'] = 0;
        return  parent::update($id, $data);
    }
}