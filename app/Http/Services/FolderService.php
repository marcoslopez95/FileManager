<?php

namespace App\Http\Services;

use App\Http\Repositories\FolderRepository;
use App\Http\Services\BaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FolderService extends BaseService
{
    protected $permitCreate = 1;
    protected $permitShow = 2;
    protected $permitUpdate = 3;
    protected $permitDelete = 4;

    public function __construct(FolderRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(Request $request)
    {
        try {
            self::CheckedPermitCreate();
            $folder = $this->repository->store($request->all());
            Storage::makeDirectory($request->name);
            return self::sendResponse(true, 'Registro insertado', $folder, 201);
        } catch (\Exception $e) {
            self::Loggin($e);
            $error = 'No se pudo guardar el registro';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }
}