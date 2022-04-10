<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function Login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            //ignorar error
            $success['token'] =  $authUser->createToken('Login')->plainTextToken;
            $success['name'] =  $authUser->name;
            //$request->session()->regenerate();
            return $this->sendResponse( $success, 'User signed in');
        }else{
            return self::sendResponse(false,'Desautorizado');
        }
    }

    public function Logout(){
        //return Auth::logout();
        try {
            //code...
            Auth::user()->currentAccessToken()->delete();
            return response()->json('Logut');
        } catch (\Exception $th) {
            return response()->json('problem');
        }
    }

/*------------------------------------- */
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
            'total'   => count($data)
        ];

        return response()->json($response, $code);
    }
}
