<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;
    protected $object;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->all();
    }

    public function store($data)
    {
        $data['created_id'] = 0;
        $data['updated_id'] = 0;
        $this->object = $this->model->create($data);
        return $this->object;
    }

    public function show($id)
    {
        return $this->object = $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $data['created_id'] = 0;
        $data['updated_id'] = 0;
        self::show($id);
        $this->object->update($data);
        return $this->object->refresh();
    }

    public function delete($id)
    {
        self::show($id);
        return $this->object->delete();
    }
}