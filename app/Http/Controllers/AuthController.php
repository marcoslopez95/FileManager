<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function Login(LoginRequest $request){
        //return $request->user();
        return $this->service->Login($request);
    }

    public function Logout(){
        return $this->service->Logout();
    }
}
