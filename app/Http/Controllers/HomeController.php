<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Event;
use App\Models\Pendaftaran;

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
        $username = Auth::user()->name;
        if(Auth::user()->roles[0]->name == "Admin") {
            $datas = Event::with('pendaftaran')->get();
        } else {
            $datas = Pendaftaran::where('user_id', Auth::user()->id)->with('event')->get();
        }
        return view('layouts.dashboard.index', compact('username', 'datas'));
    }
}
