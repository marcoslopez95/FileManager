<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\PermitController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [AuthController::class, 'Login']);
Route::post('/register', [AuthController::class, 'Register']);
Route::any('error', function (Request $request) {
    return $request->response;
})->name('error');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        //session(['user'=>$request->user()]);
        //$request->session()->put('user',$request->user());

        return $request->user();
        //return $request->session()->all();
    });
    Route::get('/logout', [AuthController::class, 'Logout']);
    Route::resource('permits', PermitController::class);
    Route::get('/folder/{folder}/files', [FolderController::class, 'FilesByFolder']);
    Route::get('/file/{file}/permits', [FileController::class, 'PermitsByFile']);
    Route::get('/folder/{folder}/permits', [FolderController::class, 'PermitsByFolder']);
    Route::resource('folders', FolderController::class);
    Route::resource('files', FileController::class);
    Route::resource('rols', RolController::class);
    ########################

    Route::middleware('is-admin')->group(function () {
        Route::post('/rol_user', [AdminController::class, 'AsignarRol']);
        Route::post('/file_user', [AdminController::class, 'AsignarArchivos']);
        Route::post('/folder_user', [AdminController::class, 'AsignarCarpetas']);
        Route::resource('users', UserController::class);
    });
});