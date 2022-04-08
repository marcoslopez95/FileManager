<?php

namespace App\Http\Services;

use App\Http\Repositories\FolderRepository;
use App\Http\Services\BaseService;

class FolderService extends BaseService
{
    public function __construct(FolderRepository $repository)
    {
        parent::__construct($repository);
    }
}