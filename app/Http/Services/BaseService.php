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

}
