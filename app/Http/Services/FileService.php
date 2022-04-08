<?php

namespace App\Http\Services;

use App\Http\Repositories\FileRepository;
use App\Http\Services\BaseService;

class FileService extends BaseService
{
    public function __construct(FileRepository $repository)
    {
        parent::__construct($repository);
    }
}