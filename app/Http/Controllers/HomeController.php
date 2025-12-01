<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TestNotification;
use Illuminate\Support\Facades\Session;
use App\Models\DiserLogin;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $diser_login = Session::get('diser_login', null);
        if(empty($diser_login)) {
            // check if not logged out
            $diser_login = DiserLogin::where('user_id', auth()->user()->id)
                ->whereNull('time_out')
                ->first();
            if(!empty($diser_login)) {
                Session::put('diser_login', $diser_login);
            }
        }

        return view('home')->with([
            'diser_login' => $diser_login
        ]);
    }
}
