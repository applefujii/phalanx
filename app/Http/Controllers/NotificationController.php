<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use App\Models\Notification__User;
use App\Models\Notification__Office;
use App\Models\Office;
use App\Models\UserType;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        //-- 古い通知を消す
        $dt = new \DateTime( "now" );
        Notification::whereDate("end_at", "<", $dt->format('Y-m-d'))->update([
            'deleted_at' => $dt->format('Y-m-d H:i:s')
        ]);

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
        $notifications = $query->orderBy('deleted_at', 'asc')->orderBy('id', 'asc')->paginate(25);

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
    public function store(NotificationRequest $request)
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
        $notification = null;
        DB::transaction(function() use($request, &$notification) {

            $dt = new \DateTime( "now" );
            $notification = Notification::create([
                'content' => $request->content,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'is_all_day' => $request->is_all_day,
                'create_user_id' => Auth::user()->id,
                'update_user_id' => Auth::user()->id,
                'created_at' => $dt->format('Y-m-d H:i:s'),
                'updated_at' => $dt->format('Y-m-d H:i:s')
            ]);

            if(isset($request->target_offices)) {
                $aItem = [];
                foreach( $request->target_offices as $to ) {
                    array_push($aItem, [
                        'notification_id' => $notification->id,
                        'office_id' => $to,
                        'create_user_id' => Auth::user()->id,
                        'created_at' => $dt->format('Y-m-d H:i:s')
                    ]);
                }

                $aChunk = array_chunk($aItem, 100);
                foreach($aChunk as $chunk){
                    Notification__Office::insert($chunk);
                }
            }

            if(isset($request->target_users)) {
                $aItem = [];
                foreach( $request->target_users as $tu ) {
                    array_push($aItem, [
                        'notification_id' => $notification->id,
                        'user_id' => $tu,
                        'create_user_id' => Auth::user()->id,
                        'created_at' => $dt->format('Y-m-d H:i:s')
                    ]);
                }

                $aChunk = array_chunk($aItem, 100);
                foreach($aChunk as $chunk){
                    Notification__User::insert($chunk);
                }
            }
        });

        if(isset($notification)) return $notification->id;
        return -1;
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
        $targetUsers = Notification__User::select('user_id')->where('notification_id', $notification->id)->orderby('user_id', 'asc')->get();
        $aTargetUsers = [];
        foreach($targetUsers as $t) {
            array_push($aTargetUsers, $t->user_id);
        }
        $targetOffices = Notification__Office::select('office_id')->where('notification_id', $notification->id)->orderby('office_id', 'asc')->get();
        $aTargetOffices = [];
        foreach($targetOffices as $t) {
            array_push($aTargetOffices, $t->office_id);
        }
        logger($aTargetUsers);
        logger($aTargetOffices);
        return view("notification.edit", compact("notification", "aTargetUsers", "aTargetOffices"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationRequest $request, $id)
    {
        $id = $this->updateDetail($request, $id);

        return redirect()->route("notification.index", $parameters = [], $status = 302, $headers = []);
    }

    public function updateDetail(Request $request, $id)
    {
        $notification = null;
        DB::transaction(function() use($request, $id, $notification) {
            $dt = new \DateTime( "now" );
            $notification = Notification::where("id", $id)->update([
                'content' => $request->content,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'is_all_day' => $request->is_all_day,
                'update_user_id' => Auth::user()->id,
                'delete_user_id' => null,
                'updated_at' => $dt->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ]);

            //-- 対象ユーザー登録
            if(isset($request->target_users)) {
                $aItem = [];
                foreach( $request->target_users as $tu ) {
                    if( $tu == "" ) continue;
                    //-- 既に登録されていたら飛ばす
                    $fFind = Notification__User::where('notification_id', $id)->where('user_id', $tu)->first();
                    if( $fFind != null ) continue;

                    array_push($aItem, [
                        'notification_id' => $id,
                        'user_id' => $tu,
                        'create_user_id' => Auth::user()->id,
                        'created_at' => $dt->format('Y-m-d H:i:s'),
                    ]);
                }
                $aChunk = array_chunk($aItem, 100);
                foreach($aChunk as $chunk){
                    Notification__User::insert($chunk);
                }

                //-- 対象外ユーザー削除
                $reduction = array_filter($request->old_target_users, function($e) use($request) {
                    if(in_array($e, $request->target_users)) return false;
                    return true;
                });
                foreach( $reduction as $tu ) {
                    Notification__User::where("user_id", $tu)->delete();
                }
            }

            //-- 対象事業所登録
            if(isset($request->target_offices)) {
                $aItem = [];
                foreach( $request->target_offices as $to ) {
                    if( $to == "" ) continue;
                    //-- 既に登録されていたら飛ばす
                    $fFind = Notification__Office::select("id")->where('notification_id', $id)->where('office_id', $to)->first();
                    if( $fFind != null ) continue;

                    array_push($aItem, [
                        'notification_id' => $id,
                        'office_id' => $to,
                        'create_user_id' => Auth::user()->id,
                        'created_at' => $dt->format('Y-m-d H:i:s'),
                    ]);
                }
                $aChunk = array_chunk($aItem, 100);
                foreach($aChunk as $chunk){
                    Notification__Office::insert($chunk);
                }

                //-- 対象外事業所削除
                $reduction = array_filter($request->old_target_offices, function($e) use($request) {
                    if(in_array($e, $request->target_offices)) return false;
                    return true;
                });
                foreach( $reduction as $to ) {
                    Notification__Office::where("office_id", $to)->delete();
                }
            }
        });

        if(isset($notification)) return $id;
        return -1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function() use($id) {
            $dt = new \DateTime( "now" );
            $notification = Notification::where("id", $id)->update([
                'delete_user_id' => Auth::user()->id,
                'deleted_at' => $dt->format('Y-m-d H:i:s')
            ]);
            Notification__User::where("notification_id", $id)->delete();
        });

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
            'created_at' => $dt->format('Y-m-d H:i:s')
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
        $notifications = Notification__User::where("id", $id)->delete();

        return;
    }


    //--------------------- リレーションテーブル操作 notification__office ----------------------

    /**
     * @return \Illuminate\Http\Response
     */
    public function notification__office_store(Request $request)
    {
        $dt = new \DateTime( "now" );
        $notifications = Notification__Office::create([
            'notification_id' => $request->notification_id,
            'user_id' => $request->office_id,
            'create_user_id' => Auth::user()->id,
            'created_at' => $dt->format('Y-m-d H:i:s')
        ]);

        return;
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notification__office_destroy($id)
    {
        $dt = new \DateTime( "now" );
        $notifications = Notification__Office::where("id", $id)->delete();

        return;
    }

}
