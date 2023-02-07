<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class WithdrawController
 */
class WithdrawController extends Controller
{
    public function index(Request $request, $currency)
    {
        return view('withdraw.index');
    }
}
