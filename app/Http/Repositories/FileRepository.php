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

    public function filtro($request)
    {
        $files = $this->model->filter($request)->get();
        return $files;
    }

    public function saludo(){
        return 'hola';
    }
}
