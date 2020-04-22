<?php

namespace App\Http\Controllers\User;

use App\Coupon;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
        $this->middleware('auth:api_user', ['except' => ['postLoginPassword']]);
    }
    public function postLoginPassword(Request $request)
    {
        $user = User::where('mobile', $request['mobile'])
            ->where('password', md5(md5($request['password'])))
            ->where('active',1)
            ->first();


        if ( !isset($user) ) {
            return response()->json([
                'status' => 'error',
                'status_number' => '3',
                'message' => 'حساب وجود ندارد',
            ], 401);
        }
        $token = auth()->guard('api_user')->login($user);
        return $this->respondWithToken($token, $user);
    }
    public function getCoupons(){
        $user = $this->whoIs('api_user');

        $coupons = Coupon::select('id as coupon_id', 'type', 'name', 'amount', 'link', 'message')->where('user_id', $user->id)->orWhere('user_id', 0)->get();

        return Response::json([
            'status' => 'ok',
            'status_number' => '1',
            'message' => 'کوپن های یک کاربر',
            'coupons' => $coupons,
        ]);
    }
    public function getCoupon(Request $request){
        $rules = [
            'coupon_id' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::json([
                'status' => 'error',
                'message' => 'اطلاعات کامل نیست',
                'status_number' => '2',
                'fails' => $validator->errors(),
            ]);
        }
        $user = $this->whoIs('api_user');
        $coupon_id = $request['coupon_id'];

        $coupon = Coupon::where('id', $coupon_id)->whereRaw("( user_id = $user->id OR user_id = 0 )")->first();
        if (isset($coupon)) {
            return Response::json([
                'status' => 'ok',
                'status_number' => '1',
                'message' => 'کوپن',
                'coupon' => $coupon
            ]);
        }


        return Response::json([
            'status' => 'error',
            'status_number' => '3',
            'message' => 'عدم کوپنا'
        ]);
    }
}
