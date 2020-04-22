<?php

namespace App\Http\Controllers\Admin;


use App\Admin_Author;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    private $paginate;
    private $operator;
    function __construct()
    {

        $this->paginate = 10;
        $this->SetHeader();
        $this->middleware('auth:api', ['except' => ['postLogin']]);
    }
    public function postLogin(Request $request)
    {
        $credentials = request(['username', 'password']);
        $username = $request['username'];
        $password = $request['password'];

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(
                [
                    'status_number' => '5',
                    'status' => 'error',
                    'message' => 'عدم کاربر',
                ], 401);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'WebService',
            'expires_in' => 180 * 60,
            'status_number' => 1,
            'status' => 'ok',
        ]);


    }


    public function postMe()
    {
        $user = $this->whoIs('api');


        if( isset($user)){
            $store_id = $user->store_id;

            $store = Store::where('id', $store_id)->first();

            $user->type_site = $store->status;
            return Response::json([
                'message' => 'کاربر',
                'status_number' => 1,
                'status' => 'ok',
                'user' => $user,
            ]);
        }else{
            return Response::json([
                'message' => 'عدم کاربر',
                'status_number' => 2,
                'status' => 'error',
            ]);
        }
    }
    public function postLogout()
    {
        auth()->logout();
        return Response::json([
            'status' => 'ok',
            'message' => '',
            'status_number' => '1'
        ]);
    }




    public function postRefresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


}
