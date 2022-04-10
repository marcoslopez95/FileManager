<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\PermitController;
use App\Http\Controllers\RolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login',[AuthController::class,'Login']);
Route::get('error', function(Request $request){

    return $request->response;
})->name('error');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user', function (Request $request) {
        //session(['user'=>$request->user()]);
        //$request->session()->put('user',$request->user());

        return $request->user()->roles;
        //return $request->session()->all();
    });
    Route::get('/logout',[AuthController::class,'Logout']);
    Route::resource('permits', PermitController::class);
    Route::resource('folders', FolderController::class);
    Route::resource('files', FileController::class);
    Route::resource('rols', RolController::class);
    ########################
    Route::post('/rol_user', [AdminController::class,'AsignarRol']);
    Route::post('/file_user', [AdminController::class,'AsignarArchivos']);

});


