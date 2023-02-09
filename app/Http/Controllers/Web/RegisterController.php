<?php

namespace App\Http\Controllers\Web;

use App\Models\Currency;
use App\Models\User;
use App\Models\UserStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'login'    => 'required',
                'email'    => 'required',
                'password' => 'required'
            ]);

            $checkLogin = User::where(['login' => $request->get('login')])->first();
            if ($checkLogin) {
                return back()->withInput($request->input())->with(['login' => 'Логин уже занят', 'tab' => 'register']);
            }

            $checkEmail = User::where(['email' => $request->get('email')])->first();
            if ($checkEmail) {
                return back()->withInput($request->input())->with(['email' => 'Email уже занят', 'tab' => 'register']);
            }

            $user = User::create([
                'login' => $request->get('login'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password'))
            ]);

            if ($user) {
                $currencies = Currency::where('is_active', true)->orderBy('position')->get();
                foreach ($currencies as $currency) {
                    UserStatistic::create([
                        'user_id' => $user->id,
                        'currency_id' => $currency->id,
                    ]);
                }

                Auth::login($user);

                return redirect()->back()->with(['success' => 'Вы успешно зарегистрировались']);
            }
        }

        return view('auth.register');
    }
}
