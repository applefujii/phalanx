<?php
/**
 * APIを集約したコントローラー
 * 
 * @auth 藤井淳一
*/

/*
【API作成について】
通知(notification)APIを参考に作成してください。
使用例、テストは「api_test.blade.php」、および「/api_test」を参照してください。

【仕様】
※例で2つ並んでいるのは、urlフォーマットとajaxで使うjsonフォーマット
■取得系API
　・使われるであろう絞り込み条件。複数指定可能。
　　　例：
　　　　「id=5」「{id : 5}」でIDの5番を取得。
　　　　「id[]=5&id[]=6」「{id : [5,6]}」でIDの5と6番を取得。
　・ソート。複数指定可能。
　　　例：
　　　　「?sort=id」「{sort : id}」でID昇順、「?sort=-id」「{sort : -id}」でID降順
　　　　「?sort[]=office_id&sort[]=-id」「{sort : [office_id, -id]}」でoffice_id昇順、第2条件id昇順

■設定系API store, update, deleteが必要。対象のコントローラーを呼び出すことで実装。
　・単体登録
　　　例：1件登録
　　　　「?record[content]="単体登録"&record[start_at]="2022/01/01 00:00:00"&record[end_at]="2022/01/01 00:00:00"&record[is_all_day]=0」
　　　　「record : { content : "単体登録", start_at :"2022/01/01 00:00:00" , end_at : "2022/01/01 00:00:00", is_all_day : "0" }」
　　　例：1件更新
　　　　「?record[id]=5&record[content]="単体登録"&record[start_at]="2022/01/01 00:00:00"&record[end_at]="2022/01/01 00:00:00"&record[is_all_day]=0」
　　　　「record : { id : 5, content : "単体更新", start_at :"2022/01/01 00:00:00" , end_at : "2022/01/01 00:00:00", is_all_day : "0" }」
　・複数登録
　　　例：複数件登録
　　　　「records[0][content]="複数登録1"&records[0][start_at]="2022/01/01 00:00:00"&records[0][end_at]="2022/01/01 00:00:00"&records[0][is_all_day]=0&records[1][content]="複数登録2"&records[1][start_at]="2022/01/01 00:00:00"&records[1][end_at]="2022/01/01 00:00:00"&records[1][is_all_day]=1&records[2][content]="複数登録3"&records[2][start_at]="2022/01/01 00:00:00"&records[2][end_at]="2022/01/01 00:00:00"&records[2][is_all_day]=0」
　　　　「records : [
            { content : "複数登録1", start_at :"2022/01/01 00:00:00" , end_at : "2022/01/01 00:00:00", is_all_day : "0" },
            { content : "複数登録2", start_at :"2022/01/01 00:00:00" , end_at : "2022/01/01 00:00:00", is_all_day : "1" },
            { content : "複数登録3", start_at :"2022/01/01 00:00:00" , end_at : "2022/01/01 00:00:00", is_all_day : "0" }
        ]」
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Notification;
use App\Models\Notification__User;
use App\Models\Office;
use App\Models\User;
use App\Models\UserType;
use App\Models\ChatRoom;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\NotificationRequest;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Providers\FormRequestServiceProvider;
use Illuminate\Routing\Redirector;
use Log;

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
        $this->middleware('auth');
    }



    ///////////////////////////////// ユーザー //////////////////////////////////////////

    /**
     * ユーザー 取得
     * @param Request $request 検索条件[id, office_id, user_type_id, sort]
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
            if(!is_array($t_sort)) $t_sort = compact("t_sort");
            $i = 0;
            foreach( $t_sort as $s ){
                $order = "asc";
                if( preg_match("/^-/i", $s) ) $order = "desc";
                $sort[$i] = ["order" => $order, "subject" => preg_replace("/^-/i", "", $s)];
                $i++;
            }
        }

        $query = User::whereNull('deleted_at');
        if ($filter_user_id !== '')
            $query->whereIn('id', $filter_user_id);

        if ($filter_office_id !== '')
            $query->whereIn('office_id', $filter_office_id);

        if ($filter_user_type_id !== '')
            $query->whereIn('user_type_id', $filter_user_type_id);

        if ($sort !== '') {
            foreach($sort as $s) {
                $query->orderBy($s["subject"], $s["order"]);
            }
        }
        else
            $query->orderBy('id', 'asc');

        $users = $query->get();

        return json_encode($users);
    }

        /**
     * ユーザー 登録
     * @param Request $request 登録情報[user_type_id, office_id, name, name_katakana, login_name, password]
     * @return json 実行結果
     */
    public function ApiStoreUsers( Request $request )
    {
        $con = app()->make("App\Http\Controllers\Auth\RegisterController");
        if( isset($request->record) ) {
            try {
                $record_confirm = array_merge($request->record, ['password_confirmation' => $request->record["password"]]);
                $id = $con->register_return_id( new Request($record_confirm) );
            } catch(\Exception $e) {
                Log::debug($e);
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", result : '.$id.' }' );
        }
        else if( isset($request->records) ) {
            $ids = "";
            try {
                DB::transaction(function() use(&$ids, $con, $request) {
                    foreach($request->records as $r) {
                        $record_confirm = array_merge($r, ['password_confirmation' => $r["password"]]);
                        $id = $con->register_return_id( new Request($record_confirm) );
                        $ids .= strval($id) . ", ";
                    }
                });
            } catch( \Exception $e ) {
                Log::debug($e);
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", results : ['. $ids .'] }' );
        }

        return json_encode( '{ result : "Failure" }' );
    }

    /**
     * ユーザー 更新
     * @param Request $request 登録情報[id, user_type_id, office_id, name, name_katakana, login_name, password]
     * @return json 実行結果
     */
    public function ApiUpdateUsers( Request $request )
    {
        $con = app()->make("App\Http\Controllers\UserController");

        if( isset($request->record) ) {
            try {
                $user = User::where("id", $request->record["id"])->first();
                $record_confirm = array_merge($request->record, ['password_confirmation' => $request->record["password"]]);
                $eud = EditUserRequest::create($uri=route('user.update', $request->record["id"]), $method="PUT", $parameters=$record_confirm);
                $eud->user = $user;
                $eud->setContainer(app())->setRedirector(app()->make(Redirector::class));
                $eud->validateResolved();
                app()->call( [$con,'update'], ['request' => $eud, 'user' => $user] );
            } catch( \Exception $e ) {
                Log::debug($e);
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", id : ['. $request->record["id"] .'] }' );
        }
        else if( isset($request->records) ) {
            $ids = "";
            try {
                DB::transaction(function() use(&$ids, $con, $request) {
                    foreach($request->records as $r) {
                        $user = User::where("id", $r["id"])->first();
                        $record_confirm = array_merge($r, ['password_confirmation' => $r["password"]]);
                        $eud = EditUserRequest::create($uri=route('user.update', $r["id"]), $method="PUT", $parameters=$record_confirm);
                        $eud->user = $user;
                        $eud->setContainer(app())->setRedirector(app()->make(Redirector::class));
                        $eud->validateResolved();
                        app()->call( [$con,'update'], ['request' => $eud, 'user' => $user] );
                        $ids .= $r["id"] . ", ";
                    }
                });
            } catch( \Exception $e ) {
                Log::debug($e);
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", ids : ['. $ids .'] }' );
        }

        return json_encode( '{ result : "Failure" }' );
    }

    public function ApiDeleteUsers( Request $request )
    {
        $con = app()->make("App\Http\Controllers\UserController");

        if( isset($request->record) ) {
            try {
                $con->destroy( $user = User::where("id", $request->record["id"])->first() );
            } catch( \Exception $e ) {
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", id : ['. $request->record["id"] .'] }' );
        }
        else if( isset($request->records) ) {
            $ids = "";
            try {
                DB::transaction(function() use(&$ids, $con, $request) {
                    foreach($request->records as $r) {
                        $con->destroy( $user = User::where("id", $r["id"])->first() );
                        $ids .= $r["id"] . ", ";
                    }
                });
            } catch( \Exception $e ) {
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", ids : ['. $ids .'] }' );
        }
    }

    ///////////////////////////////// 事業所 //////////////////////////////////////////

    /**
     * 事業所 取得
     * @param Request $request 検索条件[id, sort]
     * @return json 取得した事業所
     */
    public function ApiGetOffices( Request $request )
    {
        $filter_office_id = $request->input('id', '');
        if ($filter_office_id != ""  &&  !is_array($filter_office_id))
        $filter_office_id = compact("filter_office_id");

        $sort = "";
        $t_sort = $request->input('sort', '');
        if ($t_sort != ""){
            $sort = [[]];
            if(!is_array($t_sort)) $t_sort = compact("t_sort");
            $i = 0;
            foreach( $t_sort as $s ){
                $order = "asc";
                if( preg_match("/^-/i", $s) ) $order = "desc";
                $sort[$i] = ["order" => $order, "subject" => preg_replace("/^-/i", "", $s)];
                $i++;
            }
        }

        $query = Office::whereNull('deleted_at');
        if ($filter_office_id !== '')
            $query->whereIn('id', $filter_office_id);

        if ($sort !== '') {
            foreach($sort as $s) {
                $query->orderBy($s["subject"], $s["order"]);
            }
        }
        else
            $query->orderBy('id', 'asc');
    
        $offices = $query->get();

        return json_encode($offices);
    }

    /**
     * 事業所 登録
     * @param Request $request 登録情報[※記入]
     * @return json 実行結果
     */
    public function ApiStoreOffices( Request $request )
    {
    }

    /**
     * 事業所 更新
     * @param Request $request 登録情報[※記入]
     * @return json 実行結果
     */
    public function ApiUpdateOffices( Request $request )
    {
    }

    /**
     * 事業所 削除
     * @param Request $request 登録情報[id]
     * @return json 実行結果
     */
    public function ApiDeleteOffices( Request $request )
    {
    }



    ///////////////////////////////// 予定通知 //////////////////////////////////////////

    /**
     * 予定通知 取得
     * @param Request $request 検索条件[id, target_id, sort]
     * @return json 実行結果
     */
    public function ApiGetNotifications( Request $request )
    {
        //---- requestから要素を取り出す。配列にする。
        $filter_notification_id = $request->input('id', null);
        if ($filter_notification_id != null  &&  !is_array($filter_notification_id))
            $filter_notification_id = compact("filter_notification_id");
        $filter_target_id = $request->input('target_id', null);
        if ($filter_target_id != null  &&  !is_array($filter_target_id))
            $filter_target_id = compact("filter_target_id");

        //-- ソートは、昇順降順と要素名に分けて配列に格納しておく。
        $sort = null;
        $t_sort = $request->input('sort', null);
        if ($t_sort != null){
            $sort = [[]];
            if(!is_array($t_sort)) $t_sort = compact("t_sort");
            $i = 0;
            foreach( $t_sort as $s ){
                $order = "asc";
                if( preg_match("/^-/i", $s) ) $order = "desc";
                $sort[$i] = ["order" => $order, "subject" => preg_replace("/^-/i", "", $s)];
                $i++;
            }
        }


        //---- データベースから取得
        $query = Notification::whereNull('deleted_at');
        if ($filter_notification_id !== null)
            $query->whereIn('id', $filter_notification_id);
        if ($filter_target_id !== null)
            $query->whereHas('notification__user', function($n__u) use($filter_target_id){
                $n__u->whereIn('user_id', $filter_target_id);
            });

        if ($sort !== null) {
            foreach($sort as $s) {
                $query->orderBy($s["subject"], $s["order"]);
            }
        }
        //-- ソート順指定がなければ、デフォルトはID昇順
        else
            $query->orderBy('id', 'asc');

        $notifications = $query->get();

        // json形式にして返す
        return json_encode($notifications);
    }

    /**
     * 予定通知 登録
     * @param Request $request 登録情報[content, start_at, end_at, is_all_day]
     * @return json 実行結果
     */
    public function ApiStoreNotifications( Request $request )
    {
        // $conで通知コントローラーを使える
        $con = app()->make("App\Http\Controllers\NotificationController");
        
        //-- 1件
        if( isset($request->record) ) {
            try {
                $id = $con->storeDetail( new Request($request->record) );
            } catch(\Exception $e) {
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", id : '.$id.' }' );
        }
        //-- 複数件
        else if( isset($request->records) ) {
            $ids = "";
            try {
                DB::transaction(function() use(&$ids, $con, $request) {
                    foreach($request->records as $r) {
                        $id = $con->storeDetail( new Request($r) );
                        $ids .= strval($id) . ", ";
                    }
                    $ids = preg_replace( "/, $/u", "", $ids );
                });
            } catch( \Exception $e ) {
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", ids : ['. $ids .'] }' );
        }
        
        return json_encode( '{ result : "Failure" }' );
    }

    /**
     * 予定通知 更新
     * @param Request $request 登録情報[id, content, start_at, end_at, is_all_day]
     * @return json 実行結果
     */
    public function ApiUpdateNotifications( Request $request )
    {
        // $conで通知コントローラーを使える
        $con = app()->make("App\Http\Controllers\NotificationController");

        if( isset($request->record) ) {
            try {
                $con->updateDetail( new Request($request->record), $request->record["id"] );
            } catch( \Exception $e ) {
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", id : ['. $request->record["id"] .'] }' );
        }
        else if( isset($request->records) ) {
            $ids = "";
            try {
                DB::transaction(function() use(&$ids, $con, $request) {
                    foreach($request->records as $r) {
                        $con->updateDetail( new Request($r), $r["id"] );
                        $ids .= $r["id"] . ", ";
                    }
                    $ids = preg_replace( "/, $/u", "", $ids );
                });
            } catch( \Exception $e ) {
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", ids : ['. $ids .'] }' );
        }

        return json_encode( '{ result : "Failure" }' );
    }

    /**
     * 予定通知 削除
     * @param Request $request 登録情報[id]
     * @return json 実行結果
     */
    public function ApiDeleteNotifications( Request $request )
    {
        // $conで通知コントローラーを使える
        $con = app()->make("App\Http\Controllers\NotificationController");

        if( isset($request->record) ) {
            try {
                $con->destroy( $request->record["id"] );
            } catch( \Exception $e ) {
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", id : ['. $request->record["id"] .'] }' );
        }
        else if( isset($request->records) ) {
            $ids = "";
            try {
                DB::transaction(function() use(&$ids, $con, $request) {
                    foreach($request->records as $r) {
                        $con->destroy( $r["id"] );
                        $ids .= $r["id"] . ", ";
                    }
                    $ids = preg_replace( "/, $/u", "", $ids );
                });
            } catch( \Exception $e ) {
                return json_encode( '{ result : "Failure" }' );
            }
            return json_encode( '{ result : "Success", ids : ['. $ids .'] }' );
        }
    }



    ///////////////////////////////// チャットルーム //////////////////////////////////////////

    /**
     * チャットルーム 取得
     * @param Request $request 検索条件[id, distinction_number, office_id, user_id, sort]
     * @return json 実行結果
     */
    public function ApiGetChatRooms(Request $request)
    {
        $filter_chat_room_id = $request->input("id", "");
        if($filter_chat_room_id != "" && !is_array($filter_chat_room_id))
            $filter_chat_room_id = compact("filter_chat_room_id");
        $filter_distinction_number = $request->input("distinction_number", "");
        if($filter_distinction_number != "" && !is_array($filter_distinction_number))
            $filter_distinction_number = compact("filter_distinction_number");
        $filter_office_id = $request->input("office_id", "");
        if($filter_office_id != "" && !is_array($filter_office_id))
            $filter_office_id = compact("filter_office_id");
        $filter_user_id = $request->input("user_id", "");
        if($filter_user_id != "" && !is_array($filter_user_id))
            $filter_user_id = compact("filter_user_id");
        
        $sort = "";
        $t_sort = $request->input("sort", "");
        if($t_sort != "") {
            $sort = [[]];
            if(!is_array($t_sort)) compact("t_sort");
            $i = 0;
            foreach($t_sort as $s) {
                $order = "asc";
                if(preg_match("/^-/i", $s)) $order = "desc";
                $sort[$i] = ["order" => $order, "subject" => preg_replace("/^-/i", "", $s)];
                $i ++;
            }
        }

        $query = ChatRoom::whereNull("deleted_at");
        
        if($filter_chat_room_id != "")
            $query->whereIn("id", $filter_chat_room_id);
        if($filter_distinction_number != "")
            $query->whereIn("distinction_number", $filter_distinction_number);
        if($filter_office_id != "")
            $query->whereIn("office_id", $filter_office_id);
        if($filter_user_id != "")
            $query->whereIn("user_id", $filter_user_id);
        
        if($sort != "") {
            foreach($sort as $s) {
                $query->orderBy($s["subject"], $s["order"]);
            }
        } else {
            $query->orderBy("id", "asc");
        }

        $chatRoom = $query->get();

        return json_encode($chatRoom);
    }

    



    ///////////////////////////////// リレーション //////////////////////////////////////////


    //------------------------ 予定通知__ユーザー ----------------------------

    /**
     * 予定通知__ユーザー 取得
     * @param Request $request 検索条件[id, notification_id, user_id, sort]
     * @return json 実行結果
     */
    public function ApiGetNotificationUser( Request $request )
    {
        $filter_notification__user_id = $request->input('id', '');
        if ($filter_notification__user_id != ""  &&  !is_array($filter_notification__user_id))
        $filter_notification__user_id = compact("filter_notification__user_id");
        $filter_notification_id = $request->input('notification', '');
        if ($filter_notification_id != ""  &&  !is_array($filter_notification_id))
        $filter_notification_id = compact("filter_notification_id");
        $filter_user_id = $request->input('user_id', '');
        if ($filter_user_id != ""  &&  !is_array($filter_user_id))
        $filter_user_id = compact("filter_user_id");

        $sort = "";
        $t_sort = $request->input('sort', '');
        if ($t_sort != ""){
            $sort = [[]];
            if(!is_array($t_sort)) $t_sort = compact("t_sort");
            $i = 0;
            foreach( $t_sort as $s ){
                $order = "asc";
                if( preg_match("/^-/i", $s) ) $order = "desc";
                $sort[$i] = ["order" => $order, "subject" => preg_replace("/^-/i", "", $s)];
                $i++;
            }
        }
        

        $query = Notification__User::whereNull('deleted_at');
        if ($filter_notification__user_id !== '')
            $query->whereIn('id', $filter_notification__user_id);
        if ($filter_notification_id !== '')
            $query->whereIn('notification_id', $filter_notification_id);
        if ($filter_user_id !== '')
            $query->whereIn('user_id', $filter_user_id);

        if ($sort !== '') {
            foreach($sort as $s) {
                $query->orderBy($s["subject"], $s["order"]);
            }
        }
        else
            $query->orderBy('id', 'asc');

        $notification__user = $query->get();

        return json_encode($notification__user);
    }

    /**
     * 予定通知__ユーザー 登録
     * @param Request $request 登録情報[notification_id, user_id]
     * @return json 実行結果
     */
    public function ApiStoreNotificationUser( Request $request )
    {
        $con = app()->make("App\Http\Controllers\NotificationController");
        $con->notification__user_store_store( $request );

        return json_encode( '{ result : "Success" }' );
    }

    /**
     * 予定通知__ユーザー 削除
     * @param Request $request 登録情報[id]
     * @return json 実行結果
     */
    public function ApiDeleteNotificationUser( Request $request )
    {
        $con = app()->make("App\Http\Controllers\NotificationController");
        $con->notification__user_destroy( $request->id );
        return json_encode( '{ result : "Success" }' );
    }


}
