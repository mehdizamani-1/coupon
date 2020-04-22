<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
//        return parent::render($request, $exception);
        try {
            $tokenFetch = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();
            if (!$tokenFetch) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'توکن تمام شده است',
                    'msg_type' => '3',
                    'access_token' => '0',
                    'status_number' => '100',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'خطا در سرور',
                    'msg_type' => '3',
                    'access_token' => '0',
                    'status_number' => '102',
                ]);
            }
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){//general JWT exception
            if( $e->getMessage() == 'Token has expired' )
                return response()->json([
                    'status' => 'error',
                    'message' => 'توکن تمام شده است',
                    'msg_type' => '3',
                    'access_token' => '0',
                    'status_number' => '100',
                ]);
            else
                return response()->json([
                    'status' => 'error',
                    'message' => 'توکن نامعتبر است',
                    'msg_type' => '3',
                    'access_token' => '0',
                    'status_number' => '101',
                ]);

        }
    }
}
