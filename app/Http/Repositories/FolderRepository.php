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
        $this->model->load('files');
        return parent::index();
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
