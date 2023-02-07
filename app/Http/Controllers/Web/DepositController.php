<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class DepositController
 */
class DepositController extends Controller
{
    public function index(Request $request, $currency)
    {
        return view('deposit.index');
    }
}
