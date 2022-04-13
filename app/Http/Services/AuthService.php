<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function Login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            //ignorar error
            if (count($authUser->tokens) > 0) {
                foreach ($authUser->tokens as $token) {
                    $token->delete();
                }
            }
            $success['token'] =  $authUser->createToken('Login')->plainTextToken;
            $success['token'] = substr($success['token'], 3,);
            $success['name'] =  $authUser->name;
            $success['admin'] = Auth::user()->IsAdmin();

            return $this->sendResponse($success, 'User signed in');
        } else {
            return self::sendResponse(false, 'Contrañesa Incorrecta');
        }
    }

    public function Logout()
    {
        //return Auth::logout();
        try {
            //ignorar error
            Auth::user()->currentAccessToken()->delete();
            return response()->json('Logut');
        } catch (\Exception $th) {
            return response()->json('problem');
        }
    }

    public function Register($request)
    {
        DB::beginTransaction();
        try {
            $request['password'] = Hash::make($request->password);
            $user = User::create($request->all());
            $logged_id = $user->id;
            $log = [
                'created_id' => $logged_id,
                'updated_id' => $logged_id,
            ];
            // rol 2 es lector
            $user->roles()->attach(2, $log);
            DB::commit();
            return self::sendResponse(true, 'Usuario Creado', [$user]);
        } catch (\Exception $e) {
            DB::rollback();
            self::Loggin($e);
            $error = 'No se pudo guardar el registro';
            return self::sendResponse(false, $error, $e->getMessage());
        }
    }

    /*------------------------------------- */
    public function sendResponse($success = true, $message, $data = [], $code = 200)
    {
        if (!$success) {
            if ($code == 200) {
                $code = 425;
            }
            if (!empty($errorMessages)) {
                $response['data'] = $data;
            }
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'data'    => $data,
            'total'   => count($data)
        ];

        return response()->json($response, $code);
    }

    public function Loggin(\Exception $e)
    {
        $problem = [
            'problema' => $e->getMessage(),
            'linea' => $e->getLine(),
            'archivo' => $e->getFile()
        ];
        Log::info($problem);
    }
}