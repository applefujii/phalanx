<?php
/**
 * 体験・見学申込フォームのコントローラー
 * 
 * @author Fumio Mochizuki
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrialApplicationFormController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('trial_application/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finish()
    {
        return view('trial_application/finish');
    }
}
