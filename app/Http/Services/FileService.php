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
    public function __construct(FileRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(Request $request)
    {
        $upload = $request->file('file');
        $folder = Folder::find($request->folder_id);
        $name = $upload->getClientOriginalName();
        // $extension = $upload->getClientOriginalExtension();

        try {
            self::CheckedName($name);
            $path = $upload->storeAs($folder->name,$name);
            $request['name'] = $name;
            $request['path'] = $path;
            //return $request->all();
            $file = $this->repository->store($request->all());
            return self::sendResponse(true,'Registro insertado',$file,201);
        } catch (\Exception $e) {
            $path = $folder->name.'/'.$name;
            self::Loggin($e);
            $error = 'No se pudo guardar el registro';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    public function CheckedName($name){

        $file = $this->repository->filtro(new Request(['name'=>$name]));
        if($file->count() > 0){
            throw new \Exception("Ya existe un archivo con el mismo nombre");
        }
    }
}
