<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Notification__User;
use App\Models\Office;
use App\Models\UserType;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('staff');
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

        return view('notification.index',compact('notifications', 'offices', 'user_types', 'filter_office_id', 'filter_user_type_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $this->storeDetail($request);

        return redirect()->route("notification.index", $parameters = [], $status = 302, $headers = []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDetail(Request $request)
    {
        $dt = new \DateTime( "now" );
        $notifications = Notification::create([
            'content' => $request->content,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'is_all_day' => $request->is_all_day,
            'create_user_id' => Auth::user()->id,
            'update_user_id' => Auth::user()->id,
            'created_at' => $dt->format('Y-m-d H:i:s'),
            'updated_at' => $dt->format('Y-m-d H:i:s')
        ]);

        return $notifications->id;
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
        $notification = Notification::where("id", $id)->first();
        return view("notification.edit", compact("notification"));
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
        $dt = new \DateTime( "now" );
        $notifications = Notification::where("id", $id)->update([
            'content' => $request->content,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'is_all_day' => $request->is_all_day,
            'update_user_id' => Auth::user()->id,
            'updated_at' => $dt->format('Y-m-d H:i:s')
        ]);

        return redirect()->route("notification.index", $parameters = [], $status = 302, $headers = []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dt = new \DateTime( "now" );
        $notifications = Notification::where("id", $id)->update([
            'delete_user_id' => Auth::user()->id,
            'deleted_at' => $dt->format('Y-m-d H:i:s')
        ]);

        return redirect()->route("notification.index", $parameters = [], $status = 302, $headers = []);
    }


    //--------------------- リレーションテーブル操作 notification__user ----------------------

    /**
     * @return \Illuminate\Http\Response
     */
    public function notification__user_store(Request $request)
    {
        $dt = new \DateTime( "now" );
        $notifications = Notification__User::create([
            'notification_id' => $request->notification_id,
            'user_id' => $request->user_id,
            'create_user_id' => Auth::user()->id,
            'update_user_id' => Auth::user()->id,
            'created_at' => $dt->format('Y-m-d H:i:s'),
            'updated_at' => $dt->format('Y-m-d H:i:s')
        ]);

        return;
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notification__user_destroy($id)
    {
        $dt = new \DateTime( "now" );
        $notifications = Notification__User::where("id", $id)->update([
            'delete_user_id' => Auth::user()->id,
            'deleted_at' => $dt->format('Y-m-d H:i:s')
        ]);

        return;
    }

    //--------------------- ※テスト用 ----------------------

    public function pepple_list()
    {
        //
        return view('people_list');
    }
}
