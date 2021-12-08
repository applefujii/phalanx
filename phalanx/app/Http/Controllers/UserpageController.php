<?php

/**
 * ログイン後、ユーザーに表示するページのコントローラ
 * 
 * @author Yubaru Nozato
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrialApplication;
use Illuminate\Support\Facades\Auth;

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
        // 体験申込の新規チェック
        $trial_applications = TrialApplication::whereNull('deleted_at')->where('office_id', Auth::user()->office_id)->where('is_checked', false)->get();
        $new_trial_applications = $trial_applications->isNotEmpty();
        return view("user_page", compact('new_trial_applications'));
    }
}