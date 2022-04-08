<?php

namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository;
use App\Models\File;

class FileRepository extends BaseRepository
{
    public function __construct(File $model)
    {
        parent::__construct($model);
    }

    public function store($data)
    {
        return parent::store($data);
    }

    public function update($id, $data)
    {
        return  parent::update($id, $data);
    }
}