<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseRepository
{
    protected $model;
    protected $object;
    protected $user;

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
        $this->user = Auth::user();
        $data['created_id'] = $data['updated_id'] = $this->user->id;

        $this->object = $this->model->create($data);
        return $this->object;
    }

    public function show($id)
    {
        return $this->object = $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $this->user = Auth::user();
        $data['updated_id'] = $this->user->id;
        self::show($id);
        $this->object->update($data);
        return $this->object->refresh();
    }

    public function delete($id)
    {
        $this->user = Auth::user();
        self::show($id);
        $data['updated_id'] = $this->user->id;
        return $this->object->delete();
    }

    public function CheckedAdmin()
    {
        $roles = Auth::user()->roles;
        foreach ($roles as $rol) {
            if ($rol->id == 1) {
                return true;
            }
        }
        return false;
    }
}