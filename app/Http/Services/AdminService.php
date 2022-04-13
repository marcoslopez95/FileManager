<?php

namespace App\Http\Services;

use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\FileRepository;
use App\Http\Services\BaseService;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminService extends BaseService
{
    protected $rols;
    public function __construct(AdminRepository $repository, Rol $rol)
    {
        parent::__construct($repository);
        $this->rols = $rol;
    }

    public function AsignarRol(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->repository->show($request->user);
            $logged_id = Auth::user()->id;
            $log = [
                'created_id' => $logged_id,
                'updated_id' => $logged_id,
            ];
            $user->roles()->attach($request->rols, $log);
            DB::commit();
            $user->load('roles');
            return self::sendResponse(true, 'Permisos cambiados', $user);
        } catch (\Exception $e) {
            DB::rollback();
            self::Loggin($e);
            $error = 'No se pudo actualizar el registro';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    public function AsignarCarpetas($request)
    {
        DB::beginTransaction();
        try {
            $logged_id = Auth::user()->id;
            $data = [];
            self::CheckedFolders($request);
            $permisos = self::CheckedPermitsFolders($request->permits, $request->user);
            for ($i = 0; $i < count($request->folders); $i++) {
                $data = [
                    'folder_id' => $request->folders[$i],
                    'user_id' => $request->user,
                    'created_id' => $logged_id,
                    'updated_id' => $logged_id
                ];
                $repo = $this->repository->AsignarCarpetas($request->user, $data);
                foreach ($permisos as $permiso) {
                    $l[] = $this->repository->AsignarPermisosCarpetas($repo, $permiso);
                }
            }
            $user = $this->repository->show($request->user);
            $user = $user->load('folders');
            DB::commit();
            return self::sendResponse(true, 'Permisos cambiados', $user);
        } catch (\Exception $e) {
            DB::rollback();
            self::Loggin($e);
            $error = 'No se pudo actualizar el registro';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    public function AsignarArchivos($request)
    {
        DB::beginTransaction();
        try {
            $logged_id = Auth::user()->id;
            $data = [];
            self::CheckedFiles($request);
            $permisos = self::CheckedPermitsFiles($request->permits, $request->user);
            //return $request['files'];
            foreach ($request['files'] as $file) {
                $data = [
                    'file_id' => $file,
                    'user_id' => $request->user,
                    'created_id' => $logged_id,
                    'updated_id' => $logged_id
                ];

                $repo = $this->repository->AsignarArchivos($request->user, $data);
                foreach ($permisos as $permiso) {
                    $l[] = $this->repository->AsignarPermisosArchivos($repo, $permiso);
                }
            }

            // return $l;
            // return $repo;
            // return $permisos;
            $user = $this->repository->show($request->user);
            $user = $user->load('files');
            DB::commit();
            return self::sendResponse(true, 'Permisos cambiados', $user);
        } catch (\Exception $e) {
            DB::rollback();
            self::Loggin($e);
            $error = 'No se pudo actualizar el registro';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }


    private function CheckedFolders($request)
    {
        $user = $this->repository->showFolderByUser($request->user);
        $folders_user = $user->Folders;

        foreach ($request['folders'] as $folder) {
            $folder_user = $folders_user->where('folder_id', $folder)->first();
            if ($folder_user != null && $folder_user != '') {
                throw new \Exception("El usuario ya tiene acceso a la carpeta " . $folder_user->Folder->name);
            }
        }
    }

    private function CheckedFiles($request)
    {
        $user = $this->repository->showFilesByUser($request->user);
        $files_user = $user->Files;
        foreach ($request['files'] as $file) {
            $file_user = $files_user->where('file_id', $file)->first();
            if ($file_user != null && $file_user != '') {
                throw new \Exception("El usuario ya tiene acceso al archivo " . $file_user->File->name);
            }
        }
    }

    private function CheckedPermitsFiles($permits, $user)
    {
        $user = $this->repository->show($user);
        $permisos = [];
        foreach ($user->roles as $rol) {
            foreach ($permits as $permit) {
                $bool = $rol->permits->where('id', $permit)->first();
                if ($bool) {
                    if (Str::contains($bool->name, 'Archivo')) {
                        $permisos[] = $permit;
                    }
                    // $permisos[] = $bool;
                }
            }
        }
        return $permisos;
    }

    private function CheckedPermitsFolders($permits, $user)
    {
        $user = $this->repository->show($user);
        $permisos = [];
        foreach ($user->roles as $rol) {
            foreach ($permits as $permit) {
                $bool = $rol->permits->where('id', $permit)->first();
                if ($bool) {
                    if (
                        Str::contains($bool->name, 'Carpeta') ||
                        Str::contains($bool->name, 'Crear Archivo')
                    ) {
                        $permisos[] = $permit;
                    }
                    // $permisos[] = $bool;
                }
            }
        }
        return $permisos;
    }
}