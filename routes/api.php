<?php

use Illuminate\Http\Request;

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

/*
 * User routes
 */
Route::group(['prefix' => '/user/requests'], function ($router) {
    Route::post('/login', [
        'uses' => 'User\UserController@postLoginPassword',
    ]);
    Route::post('/logout', [
        'uses' => 'User\UserController@postLogout',
    ]);
    Route::post('/refresh', [
        'uses' => 'User\UserController@postRefresh',
    ]);
    Route::post('/me', [
        'uses' => 'User\UserController@postMe',
    ]);
    /*
     * Coupons
     */
    Route::group(['prefix' => '/coupons',], function ($router) {
        Route::post('', [  // list all coupons
            'uses' => 'User\UserController@getCoupons'
        ]);
        Route::post('/coupon', [ // single coupon
            'uses' => 'User\UserController@getCoupon'
        ]);



    });
});

/*
 * Admin routes
 */

Route::group(['prefix' => '/admin/requests'], function ($router) {
    // User Section



    //Admin Controller

    Route::post('/login', [
        'uses' => 'Admin\AdminController@postLogin',
        'as' => 'admin.post.login'
    ]);
    Route::post('/logout', [
        'uses' => 'Admin\AdminController@postLogout',
        'as' => 'admin.post.logout'
    ]);
    Route::post('/refresh', [
        'uses' => 'Admin\AdminController@postRefresh',
        'as' => 'admin.post.refresh'
    ]);
    Route::post('/me', [
        'uses' => 'Admin\AdminController@postMe',
        'as' => 'admin.post.me'
    ]);



    /*
     * Coupons
     */
    Route::group(['prefix' => '/coupons',], function ($router) {
        Route::post('', [  // list all coupons
            'uses' => 'Coupon\CouponController@getCoupons'
        ]);
        Route::post('/coupon', [ // single coupon
            'uses' => 'Coupon\CouponController@getCoupon'
        ]);
        Route::post('/create', [ // create coupon
            'uses' => 'Coupon\CouponController@postCreateCoupon'
        ]);
        Route::post('/edit', [ // edit coupon
            'uses' => 'Coupon\CouponController@postEditCoupon'
        ]);
        Route::post('/remove', [ // remove coupon
            'uses' => 'Coupon\CouponController@postRemoveCoupon'
        ]);


    });

});