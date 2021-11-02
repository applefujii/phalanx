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



    //////////////////////////////////////// 取得系 //////////////////////////////////////////////

    /**
     * ユーザー取得
     * @param array $request 検索条件[id, office_id, user_type_id]
     * @return json 取得したユーザー
     */
    public function ApiGetUserList( Request $request )
    {
        $filter_user_id = $request->input('id', '');
        $filter_user_id ??= '';
        $filter_office_id = $request->input('officez_id', '');
        $filter_office_id ??= '';
        $filter_user_type_id = $request->input('user_type_id', '');
        $filter_user_type_id ??= '';

        $query = User::query();
        if ($filter_user_id !== '')
            $query->where('id', '=', $filter_user_id);
        if ($filter_office_id !== '')
            $query->where('office_id', '=', $filter_office_id);
        if ($filter_user_type_id !== '')
            $query->where('user_type_id', '=', $filter_user_type_id);
        $users = $query->orderBy('id', 'asc')->get();

        return json_encode($users);
    }

    /**
     * 事業所取得
     * @param array $request 検索条件[id]
     * @return json 取得した事業所
     */
    public function ApiGetOfficeList( Request $request )
    {
        $filter_office_id = $request->input('id', '');
        $filter_office_id ??= '';

        $query = Office::query();
        if ($filter_office_id !== '')
            $query->where('id', '=', $filter_office_id);
        $offices = $query->orderBy('id', 'asc')->get();

        return json_encode($offices);
    }



    //////////////////////////////////////// 登録系 //////////////////////////////////////////////



}
