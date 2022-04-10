<?php

namespace App\Http\Services;

use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\FileRepository;
use App\Http\Services\BaseService;
use App\Models\Rol;
use Illuminate\Http\Request;
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

    public function AsignarRol(Request $request){
        DB::beginTransaction();
        try {
            $user = $this->repository->show($request->user);
            $logged_id = Auth::user()->id;
            $log = [
                'created_id' => $logged_id,
                'updated_id' => $logged_id,
            ];
            $user->roles()->sync($request->rols,$log);
            DB::commit();
            $user->load('roles');
            return self::sendResponse(true,'Permisos cambiados',$user);
        } catch (\Exception $e) {
            DB::rollback();
            self::Loggin($e);
            $error = 'No se pudo actualizar el registro';
            return self::sendResponse(false, $error, $e->getMessage());
        }

    }
}
