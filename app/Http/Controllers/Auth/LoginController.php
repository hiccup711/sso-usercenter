<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
//      为 wordpress 单独配置一套授权
        if (! \auth('corcel')->validate([
            'username' => $request->username, // 或者也使用 'email'
            'password' => $request->password,
        ])) {
            return response('用户名或密码错误', 400);
        }
        // auth 类方法与 wordpress 模型不通用，需要重新查询一次用户
        $wp_user = \App\Models\User::query()->where('user_login', $request->username)->first();
        $token = $wp_user->createToken('ua');
        return redirect('http://wordpress.ricky.zone?token='.$token->plainTextToken);
    }
}
