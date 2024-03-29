<?php

namespace App\Http\Controllers\Web;

use App\Models\UserLoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {

                UserLoginHistory::create([
                    'user_id' => Auth::user()->id,
                    'ip' => $request->getClientIp(),
                    'user_agent' => $request->server->get('HTTP_USER_AGENT'),
                ]);

                return back()->with(['success' => 'Вы успешно вошли в кабинет']);
            }

            return back()->withInput($request->input())->with(['error' => 'Не верные данные для входа']);
        }

        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return back();
    }
}
