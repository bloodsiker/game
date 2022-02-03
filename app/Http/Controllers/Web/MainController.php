<?php

namespace App\Http\Controllers\Web;

use App\Models\Mine;
use App\Models\MineRate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class MainController
 */
class MainController extends Controller
{

    public function index(Request $request)
    {
        return view('index');
    }
}
