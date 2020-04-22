<?php

namespace App\Http\Controllers\Coupon;

use App\Admin_Author;
use App\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    private $operator;

    function __construct()
    {
        $this->operator = $this->whoIs('api');
        $this->SetHeader();
        $this->middleware('auth:api');
    }
    public function getCoupons(Request $request){
        $operator = $this->whoIs('api');
        $from_date = $request['from_date'];
        $to_date = $request['to_date'];
        $user_id = $request['user_id'];
        $brand_id = $request['brand_id'];
        $name = $request['name'];
        $active = $request['active'];
        $public_date_at = $request['public_date_at'];
        $coupon_id = $request['coupon_id'];
        $paginate = ($request['paginate'])? $request['paginate']:10;
        $coupons = Coupon::select('coupons.*');
        if ($from_date != '') {
            $from_date = explode('/', $from_date);
            $from = $this->jalali_to_gregorian((string)$from_date[0], (string)$from_date[1], (string)$from_date[2]);
            $from_date = implode('-', $from);
            $coupons->where(DB::raw('coupons.created_at'),'>=', $from_date);

        }
        if ($to_date != '') {
            $end_date = explode('/', $to_date);
            $to = $this->jalali_to_gregorian((string)$end_date[0], (string)$end_date[1], (string)$end_date[2]);
            $to_date = implode('-', $to);
            $to_date = $to_date . ' 23:59:59';
            $coupons->where(DB::raw('coupons.created_at'),'<=', $to_date);
        }
        if ($public_date_at != '') {
            $end_date = explode('/', $public_date_at);
            $to = $this->jalali_to_gregorian((string)$end_date[0], (string)$end_date[1], (string)$end_date[2]);
            $public_date_at = implode('-', $to);
            $public_date_at = $public_date_at . ' 23:59:59';
            $coupons->where(DB::raw('coupons.public_date_at'),'=', $public_date_at);
        }
        if ($user_id != '') {
            $coupons->where('user_id', '=', $user_id);
        }
        if ($active != '') {
            $coupons->where('active', '=', $active);
        }
        if ($brand_id != '') {
            $coupons->where('brand_id', '=', $brand_id);
        }
        if ($coupon_id != '') {
            $coupons->where('id', '=', $coupon_id);
        }

        if ($name != '') {
            $coupons->where('name', 'LIKE', '%'.$name.'%');
        }
        $coupons = $coupons->orderBy('id', 'desc')->paginate($paginate);
        $coupons_array = array();
        foreach ( $coupons as $coupon ){
            $coupons_array[] = $coupon;
        }
        $pages = $coupons->lastPage();
        return Response::json([
            'status' => 'ok',
            'status_number' => '1',
            'message' => 'کوپن ها',
            'coupons' => $coupons_array,
            'pages' => $pages,
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
        $operator = $this->whoIs('api');
        $coupon_id = $request['coupon_id'];

        $coupon = Coupon::find($coupon_id);
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
    public function postCreateCoupon(Request $request)
    {
        $rules = [
            'type' => 'required|numeric',
            'user_id' => 'nullable|numeric',
            'brand_id' => 'required|numeric',
            'coupon' => 'required|unique:coupons',
            'name' => 'required|max:55',
            'message' => 'nullable|max:255',
            'link' => 'nullable|max:255',
            'amount' => 'required|numeric',
            'public_date_at' => 'required',
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
        $operator = $this->whoIs('api');

        $new_coupon = new Coupon();
        $new_coupon->user_id = (integer)$request['user_id'];
        $new_coupon->type = $request['type'];
        $new_coupon->brand_id = $request['brand_id'];
        $new_coupon->coupon = $request['coupon'];
        $new_coupon->active = $request['active'] ? $request['active']:1;
        $new_coupon->name = $request['name'];
        $new_coupon->message = $request['message'];
        $new_coupon->link = $request['link'];
        $new_coupon->amount = $request['amount'];
        $from_date = explode('/', $request['public_date_at']);
        $from = $this->jalali_to_gregorian((string)$from_date[0], (string)$from_date[1], (string)$from_date[2]);
        $public_date_at = implode('-', $from) . ' 23:59:59';
        $new_coupon->public_date_at = $public_date_at;
        if ($new_coupon->save()) {
            return Response::json([
                'status' => 'ok',
                'status_number' => '1',
                'message' => 'ثبت شد',
            ]);
        } else {
            return Response::json([
                'status' => 'error',
                'status_number' => '3',
                'message' => 'خطا در ذخیره',
            ]);
        }


    }
    public function postEditCoupon(Request $request)
    {
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


        $coupon = Coupon::find($request['coupon_id']);
        if( !isset($coupon) ){

            return Response::json([
                'status' => 'error',
                'status_number' => '3',
                'message' => 'عدم کوپنا'
            ]);
        }
        if( $request['user_id'] != '' )
            $coupon->user_id = (integer)$request['user_id'];
        if( $request['type'] != '' )
            $coupon->type = $request['type'];
        if( $request['brand_id'] != '' )
            $coupon->brand_id = $request['brand_id'];
        if( $request['active'] != '' )
            $coupon->active = $request['active'];
        if( $request['name'] != '' )
            $coupon->name = $request['name'];
        if( $request['message'] != '' )
            $coupon->message = $request['message'];
        if( $request['link'] != '' )
            $coupon->link = $request['link'];
        if( $request['amount'] != '' )
            $coupon->amount = $request['amount'];
        if( $request['public_date_at'] != '' ){
            $from_date = explode('/', $request['public_date_at']);
            $from = $this->jalali_to_gregorian((string)$from_date[0], (string)$from_date[1], (string)$from_date[2]);
            $public_date_at = implode('-', $from) . ' 23:59:59';
            $coupon->public_date_at = $public_date_at;
        }

        if ($coupon->update()) {
            return Response::json([
                'status' => 'ok',
                'status_number' => '1',
                'message' => 'ویرایش شد',
            ]);
        } else {
            return Response::json([
                'status' => 'error',
                'status_number' => '3',
                'message' => 'خطا در ویرایش',
            ]);
        }


    }

    public function postRemoveCoupon(Request $request){
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
        $operator = $this->whoIs('api');
        $coupon_id = $request['coupon_id'];

        $res = Coupon::where('id', $coupon_id)->delete();
        if ($res) {
            return Response::json([
                'status' => 'ok',
                'status_number' => '1',
                'message' => 'حذف شد',
            ]);
        }


        return Response::json([
            'status' => 'error',
            'status_number' => '3',
            'message' => 'خطا در حذف'
        ]);
    }
}
