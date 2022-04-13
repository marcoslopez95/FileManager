<?php

namespace App\Http\Services;

use App\Http\Repositories\FileRepository;
use App\Http\Services\BaseService;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileService extends BaseService
{
    protected $permitCreate = 5;
    protected $permitShow = 6;
    protected $permitUpdate = 7;
    protected $permitDelete = 8;

    public function __construct(FileRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(Request $request)
    {
        $upload = $request->file('file');
        // $folder = Folder::find($request->folder_id);
        $folder = Folder::firstWhere('name', $request->folder);
        $name = $upload->getClientOriginalName();
        // $extension = $upload->getClientOriginalExtension();

        try {
            self::CheckedPermitCreate();
            self::CheckedName($name);
            if (!self::CheckedIsAdmin()) {
                self::CheckedFolderPermit($folder->id);
            }
            $path = $upload->storeAs($folder->name, $name);
            $request['name'] = $name;
            $request['folder_id'] = $folder->id;
            $request['path'] = $path;
            //return $request->all();
            $file = $this->repository->store($request->all());
            return self::sendResponse(true, 'Registro insertado', $file, 201);
        } catch (\Exception $e) {
            $path = $folder->name . '/' . $name;
            self::Loggin($e);
            $error = 'No se pudo guardar el registro';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    public function PermitsByFile($file)
    {
        try {
            $archivo = $this->repository->filtro(new Request(['name' => $file]))->first();
            if (!self::CheckedIsAdmin()) {
                return self::CheckedFilePermit($archivo);
            }
        } catch (\Exception $e) {
            self::Loggin($e);
            $error = 'No se realizar la consulta';
            return self::sendResponse(false, $error, $e->getMessage());
        }

        return $archivo->usuarios;
    }

    ##--------------------------------------------

    private function CheckedFilePermit($file)
    {
        return $file->load('usuarios.permits');
        $bool = $file->where('user_id', Auth::user()->id)->first();
        if ($bool == null || $bool == '') {
            throw new \Exception("No tiene permisos para acceder al archivo");
        }
    }
    private function CheckedName($name)
    {
        $file = $this->repository->filtro(new Request(['name' => $name]));
        if ($file->count() > 0) {
            throw new \Exception("Ya existe un archivo con el mismo nombre");
        }
    }

    private function CheckedFolderPermit($folder)
    {
        $folder_permits = Auth::user()->Folders;
        if ($folder_permits->where('id', $folder)->count() == 0) {
            throw new \Exception("No tiene permisos para agregar archivos a esa carpeta");
        }
    }
}