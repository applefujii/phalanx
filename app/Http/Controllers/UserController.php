<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\UserType;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter_office_id = $request->input('office', '');
        $filter_office_id ??= '';
        $filter_user_type_id = $request->input('user_type', '');
        $filter_user_type_id ??= '';
        $users_query = User::query();
        if ($filter_office_id !== '') {
            $users_query->where('office_id', '=', $filter_office_id);
        }
        if ($filter_user_type_id !== '') {
            $users_query->where('user_type_id', '=', $filter_user_type_id);
        }
        $offices = Office::orderBy('id', 'asc')->get();
        $user_types = UserType::orderBy('id', 'asc')->get();

        $users = $users_query->orderBy('id', 'asc')->paginate(25);

        return view("user_master_index", compact('users', 'offices', 'user_types', 'filter_office_id', 'filter_user_type_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        //
    }
}
