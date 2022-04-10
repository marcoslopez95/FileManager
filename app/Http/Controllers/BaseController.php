<?php

namespace App\Http\Controllers;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    protected $service;

    public function __construct(BaseService $service)
    {
        $this->service = $service;
    }

    public function _index()
    {
        return $this->service->index();
    }

    public function _store(Request $request)
    {
        return $this->service->store($request);
    }

    public function _show($id)
    {
        return $this->service->show($id);
    }

    public function _update($id, Request $request)
    {
        return $this->service->update($id, $request);
    }

    public function _delete($id)
    {
        return $this->service->delete($id);
    }
}
