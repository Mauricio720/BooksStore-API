<?php

namespace App\Http\Controllers\Painel;

use App\Models\Book;
use App\Http\Controllers\Controller;

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
        $array=[];
        $array['books']=Book::orderBy('id','DESC')->get();

        return view('home',$array);
    }
}
