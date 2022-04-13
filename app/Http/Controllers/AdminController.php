<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AsignarArchivosRequest;
use App\Http\Requests\Admin\AsignarCarpetasRequest;
use App\Http\Requests\Admin\AsignarRolRequest;
use App\Http\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    public function AsignarRol(AsignarRolRequest $request)
    {

        return $this->service->AsignarRol($request);
    }

    public function AsignarArchivos(AsignarArchivosRequest $request)
    {
        return $this->service->AsignarArchivos($request);
    }

    public function AsignarCarpetas(AsignarCarpetasRequest $request)
    {
        return $this->service->AsignarCarpetas($request);
    }
}