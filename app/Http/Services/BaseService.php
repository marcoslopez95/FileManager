<?php

namespace App\Http\Services;

use App\Http\Repositories\BaseRepository;
use Facade\FlareClient\Http\Exceptions\BadResponse;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BaseService
{
    protected $repository;
    protected $permitCreate = 1;
    protected $permitDelete = 2;
    protected $permitUpdate = 3;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        try {
            $object = $this->repository->index();

            return self::sendResponse(true,'Index',$object);
        } catch (\Exception $e) {
            DB::rollback();
            self::Loggin($e);
            $error = 'No se pudo guardar el registro';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            self::CheckedPermitCreate();
            $object = $this->repository->store($request->all());
            DB::commit();
            return self::sendResponse(true,'Registro insertado',$object,201);
        } catch (\Exception $e) {
            DB::rollback();
            self::Loggin($e);
            $error = 'No se pudo guardar el registro';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $object = $this->repository->show($id);
            return self::sendResponse(true,'Mostrar Registro',$object);
        } catch (\Exception $e) {
            DB::rollback();
            self::Loggin($e);
            $error = 'No se pudo hacer la consulta';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            self::CheckedPermitUpdated();
            $object = $this->repository->update($id, $request->all());
            DB::commit();

            return self::sendResponse(true,'Registro Actualizado',$object);
        } catch (\Exception $e) {
            DB::rollback();
            self::Loggin($e);
            $error = 'No se pudo actualizar';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            self::CheckedPermitDelete();
            $object = $this->repository->delete($id);
            DB::commit();

            return self::sendResponse(true,'Registro Eliminado');

        } catch (\Exception $e) {
            DB::rollback();
            self::Loggin($e);
            $error = 'No se puede eliminar';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    public function sendResponse($success = true, $message, $data = [], $code = 200)
    {
        if(!$success){
            if($code == 200){
                $code = 425;
            }
            if(!empty($errorMessages)){
                $response['data'] = $data;
            }
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ];

        if(!$success){
            $response['total'] = 0;
        }else{
            if($message != 'Index'){
                $response['total'] = 1;
            }else{
                $response['total'] = count($data);
            }
        }

        return response()->json($response, $code);
    }

    public function Loggin(\Exception $e){
        $problem = [
            'problema' => $e->getMessage(),
            'linea' => $e->getLine(),
            'archivo' => $e->getFile()
        ];
        Log::info($problem);
    }

    public function CheckedPermitCreate()
    {
        $bool = false;
        $roles = Auth::user()->roles;
        $roles->where('id', 1)->first();
        if($roles->where('id', 1)->first()){
            return;
        };
        foreach (Auth::user()->roles as $rol) {
            foreach ($rol->permits as $permit) {
                if ($permit == $this->permitCreate) {
                    $bool = true;
                }
            }
        }
        if (!$bool) {
            throw new \Exception("No tiene permisos para esta acción");
        }
    }

    public function CheckedPermitDelete()
    {
        $bool = false;
        $roles = Auth::user()->roles;
        if($roles->where('id', 1)->first()){
            return;
        };

        foreach (Auth::user()->roles as $rol) {
            foreach ($rol->permits as $permit) {
                if ($permit == $this->permitDelete) {
                    $bool = true;
                }
            }
        }
        if (!$bool) {
            throw new \Exception("No tiene permisos para esta acción");
        }
    }

    public function CheckedPermitUpdated()
    {
        $bool = false;
        $roles = Auth::user()->roles;
        if($roles->where('id', 1)->first()){
            return;
        };

        foreach (Auth::user()->roles as $rol) {
            foreach ($rol->permits as $permit) {
                if ($permit == $this->permitUpdate) {
                    $bool = true;
                }
            }
        }
        if (!$bool) {
            throw new \Exception("No tiene permisos para esta acción");
        }
    }

}
