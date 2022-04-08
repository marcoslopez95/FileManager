<?php

namespace App\Http\Services;

use App\Http\Repositories\BaseRepository;
use Facade\FlareClient\Http\Exceptions\BadResponse;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseService
{
    protected $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }
    public function error($error)
    {
        return [
            'status' => 425,
            'error' => true,
            'message' => $error
        ];
    }

    public function index()
    {
        try {
            $list = $this->repository->index();
            $mensaje = [
                'status' => 200,
                'datos' => $list,
                'total' => count($list)
            ];

            return Response()->json($mensaje);
        } catch (\Exception $e) {
            return Response()->json(self::error($e->getMessage()), 425);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $object = $this->repository->store($request->all());
            $mensaje = [
                'status' => 201,
                'registro' => $object
            ];
            DB::commit();
            return Response()->json($mensaje, 201);
        } catch (\Exception $e) {
            DB::rollback();
            return Response()->json(self::error($e->getMessage()), 425);
        }
    }

    public function show($id)
    {
        try {
            $object = $this->repository->show($id);
            $mensaje = [
                'registro' => $object
            ];

            return Response()->json($mensaje);
        } catch (\Exception $e) {
            return Response()->json(self::error($e->getMessage()), 425);
        }
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $object = $this->repository->update($id, $request->all());
            $mensaje = [
                'registro' => $object
            ];
            DB::commit();
            return Response()->json($mensaje);
        } catch (\Exception $e) {
            DB::rollback();
            return Response()->json(self::error($e->getMessage()), 425);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $object = $this->repository->delete($id);
            $mensaje = [
                'mensaje' => 'Registro Eliminado'
            ];
            DB::commit();
            return Response()->json($mensaje);
        } catch (\Exception $e) {
            DB::rollback();
            return Response()->json(self::error($e->getMessage()), 425);
        }
    }
}