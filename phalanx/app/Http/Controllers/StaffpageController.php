<?php

/**
 * ログイン後、ユーザーに表示するページのコントローラ
 * 
 * @author Yubaru Nozato
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffpageController extends Controller
{
    public function index()
    {
        return view("staff_page");
    }
}