<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\FileStoreRequest;
use App\Http\Requests\File\FileUpdateRequest;
use App\Http\Services\FileService;
use Illuminate\Http\Request;

class FileController extends BaseController
{
    public function __construct(FileService $service)
    {
        parent::__construct($service);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return parent::_index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileStoreRequest $request)
    {
        return parent::_store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return parent::_show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FileUpdateRequest $request, $id)
    {

        return parent::_update($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return parent::_delete($id);
    }

    public function PermitsByFile($file)
    {
        return $this->service->PermitsByFile($file);
    }

    public function edit($file){
        return $this->service->edit($file);
    }
}
