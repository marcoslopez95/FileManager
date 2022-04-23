<?php

namespace App\Http\Services;

use App\Http\Repositories\FolderRepository;
use App\Http\Services\BaseService;
use App\Models\Folder;
use App\Models\User;
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

    public function filesByFolder($folder)
    {
        try {
            $user = Auth::user();
            //$user = Folder::with('files.usuarios')->get();
            if (self::CheckedIsAdmin()) {
                $folder = Folder::where('name', $folder)->first();
                $files = $folder->load('files')->files;
                return self::sendResponse(true, 'Archivos por carpeta', $files);
            }
            $user->load('Files.file.folder');
            $files = collect();
            foreach ($user->files as $files_user) {
                if ($files_user->file->folder->name == $folder) {
                    $files = $files->concat(($files_user->only('file')));
                }
            }
            return self::sendResponse(true, 'Archivos por carpeta', $files);
        } catch (\Exception $e) {
            self::Loggin($e);
            $error = 'Error al generar la consulta';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    public function CheckedFolders($folder_req)
    {
        $carpeta = collect();
        $user = $this->repository->showFolderByUser(Auth::user()->id);
        $folders_user = $user->Folders;

        foreach ($folders_user as $folder) {
            if ($folder->folder->id == $folder_req)
                $carpeta = $carpeta->concat($folder->only('folder'));
        }
        return $carpeta->first();
    }
}