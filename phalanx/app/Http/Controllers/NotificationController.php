<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Office;
use App\Models\UserType;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        //
        $filter_office_id = $request->input('office', '');
        $filter_office_id ??= '';
        $filter_user_type_id = $request->input('user_type', '');
        $filter_user_type_id ??= '';

        $query = Notification::query();
        if ($filter_office_id !== '')
            $query->where('office_id', '=', $filter_office_id);
        if ($filter_user_type_id !== '')
            $query->where('user_type_id', '=', $filter_user_type_id);
        $notifications = $query->orderBy('id', 'asc')->paginate(25);

        $offices = Office::orderBy('id', 'asc')->get();
        $user_types = UserType::orderBy('id', 'asc')->get();

        return view('notification_index',compact('notifications', 'offices', 'user_types', 'filter_office_id', 'filter_user_type_id'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pepple_list()
    {
        //
        return view('people_list');
    }
}
