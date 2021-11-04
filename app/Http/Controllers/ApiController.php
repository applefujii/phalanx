<?php
/**
 * APIを集約したコントローラー
 * 
 * @auth 藤井淳一
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\Office;
use App\Models\User;
use App\Models\UserType;

use App\Http\Controllers\NotificationController;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // ※$this->middleware('auth');
    }



    ///////////////////////////////// ユーザー //////////////////////////////////////////

    /**
     * ユーザー 取得
     * @param array $request 検索条件[id, office_id, user_type_id, sort]
     * @return json 取得したユーザー
     */
    public function ApiGetUsers( Request $request )
    {
        $filter_user_id = $request->input('id', '');
        if ($filter_user_id != ""  &&  !is_array($filter_user_id))
            $filter_user_id = compact("filter_user_id");
        $filter_office_id = $request->input('office_id', '');
        if ($filter_office_id != ""  &&  !is_array($filter_office_id))
            $filter_office_id = compact("filter_office_id");
        $filter_user_type_id = $request->input('user_type_id', '');
        if ($filter_user_type_id != ""  &&  !is_array($filter_user_type_id))
            $filter_user_type_id = compact("filter_user_type_id");
        $sort = "";
        $t_sort = $request->input('sort', '');
        if ($t_sort != ""){
            $sort = [[]];
            if(!is_array($t_sort)) $sort = compact("t_sort");
            foreach( $t_sort as $s ){
                preg_match("/^-/i", $s);
                preg_replace("/^-/i", "", $s);
            }
        }

        $query = User::whereNull('deleted_at');
        if ($filter_user_id !== '')
            $query->whereIn('id', $filter_user_id);

        if ($filter_office_id !== '')
            $query->whereIn('office_id', $filter_office_id);

        if ($filter_user_type_id !== '')
            $query->whereIn('user_type_id', '=', $filter_user_type_id);

        $users = $query->orderBy('id', 'asc')->get();

        return json_encode($users);
    }


    ///////////////////////////////// 事業所 //////////////////////////////////////////

    /**
     * 事業所 取得
     * @param array $request 検索条件[id]
     * @return json 取得した事業所
     */
    public function ApiGetOffices( Request $request )
    {
        $filter_office_id = $request->input('id', '');
        if ($filter_office_id != ""  &&  !is_array($filter_office_id))
        $filter_office_idd = compact("filter_office_id");

        $query = Office::whereNull('deleted_at');
        if ($filter_office_id !== '')
            $query->whereIn('id', $filter_office_id);
        $offices = $query->orderBy('id', 'asc')->get();

        return json_encode($offices);
    }



    ///////////////////////////////// 予定通知 //////////////////////////////////////////

    /**
     * 予定通知 取得
     * @param array $request 検索条件[id]
     * @return json 実行結果
     */
    public function ApiGetNotifications( Request $request )
    {
        $filter_notification_id = $request->input('id', '');
        if ($filter_notification_id != ""  &&  !is_array($filter_notification_id))
        $filter_notification_id = compact("filter_notification_id");

        $query = Notification::whereNull('deleted_at');
        if ($filter_notification_id !== '')
            $query->whereIn('id', $filter_notification_id);
        $notifications = $query->orderBy('id', 'asc')->get();

        return json_encode($notifications);
    }

    /**
     * 予定通知 登録
     * @param array $request 登録情報[content, start_at, end_at, is_all_day]
     * @return json 実行結果
     */
    public function ApiStoreNotifications( Request $request )
    {
        $con = app()->make("App\Http\Controllers\NotificationController");
        $con->store( $request );

        return json_encode( '{ result : "Success" }' );
    }

    /**
     * 予定通知 更新
     * @param array $request 登録情報[id, content, start_at, end_at, is_all_day]
     * @return json 実行結果
     */
    public function ApiUpdateNotifications( Request $request )
    {
        $con = app()->make("App\Http\Controllers\NotificationController");
        $con->update( $request, $request->id );

        return json_encode( '{ result : "Success" }' );
    }

    /**
     * 予定通知 削除
     * @param array $request 登録情報[id]
     * @return json 実行結果
     */
    public function ApiDeleteNotifications( Request $request )
    {
        $con = app()->make("App\Http\Controllers\NotificationController");
        $con->destroy( $request->id );
        return json_encode( '{ result : "Success" }' );
    }


}
