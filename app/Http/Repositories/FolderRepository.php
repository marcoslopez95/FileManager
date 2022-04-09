<?php

namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository;
use App\Models\Folder;
use Carbon\Carbon;

class FolderRepository extends BaseRepository
{
    public function __construct(Folder $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $folders = $this->model->with('files')->get();
        foreach ($folders as $folder) {
            $folder->created_at = Carbon::parse($folder->created_at)->format('m-d-Y');
        }
        return $folders;
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
