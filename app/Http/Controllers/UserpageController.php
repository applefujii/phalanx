<?php

/**
 * ログイン後、ユーザーに表示するページのコントローラ
 * 
 * @author Yubaru Nozato
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserpageController extends Controller
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



    public function index()
    {
        /* $users = User::orderBy("user_type_id")->get(); */
        return view("user_page");
    }
}