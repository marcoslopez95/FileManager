<?php

namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository;
use App\Models\Folder;

class FolderRepository extends BaseRepository
{
    public function __construct(Folder $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        return $this->model->with('files')->all();
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
