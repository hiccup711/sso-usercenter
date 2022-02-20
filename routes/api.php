<?php

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

Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    return response([
        'name' => $request->user()->user_login,
    ]);
});

Route::post('/login', function (Request $request) {
    if (\auth('corcel')->validate([
        'username' => $request->username, // 或者也使用 'email'
        'password' => $request->password,
    ])) {
        $wp_user = \App\Models\User::query()->first();
        $token = $wp_user->createToken('ua');
        return redirect('http://wordpress.test?token='.$token->plainTextToken);
    }
})->name('api.login');
