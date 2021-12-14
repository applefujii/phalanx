<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\UserType;
use App\Models\ChatRoom;
use App\Models\ChatRoom__User;
use App\Models\ChatText;
use App\Http\Requests\EditUserRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct() {
        $this->middleware('staff');
        $this->middleware('password.confirm');
    }

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
        $offices = Office::orderBy('sort', 'asc')->get();
        $user_types = UserType::orderBy('id', 'asc')->get();

        $users = $users_query->join('offices', 'users.office_id', '=', 'offices.id')->join('user_types', 'users.user_type_id', '=', 'user_types.id')->orderBy('user_types.id', 'asc')->orderBy('offices.sort', 'asc')->orderBy('users.id', 'asc')->select('users.id', 'users.name', 'users.user_type_id', 'users.office_id')->paginate(25);

        return view("user_master.index", compact('users', 'offices', 'user_types', 'filter_office_id', 'filter_user_type_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $offices = Office::orderBy('sort', 'asc')->get();
        $user_types = UserType::orderBy('id', 'asc')->get();
        return view("user_master.create", compact('offices', 'user_types'));
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
        $offices = Office::orderBy('sort', 'asc')->get();
        $user_types = UserType::orderBy('id', 'asc')->get();
        return view("user_master.edit", compact('user', 'offices', 'user_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, user $user)
    {
        $validated = $request->validated();
        $user->fill(array_merge($validated, ['password' => Hash::make($request->password)]));
        $now = Carbon::now();
        $user->fill(['update_user_id' => Auth::id(), 'updated_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss')]);
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        if ($user->id == Auth::id()) {
            abort(403);
        }
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
        
        //削除するユーザーが職員以外の場合、対職員用のチャットルームを削除
        if($user->user_type_id !== 1) {
            $con = app()->make("App\Http\Controllers\ChatRoomController");
            $chatRooms = ChatRoom::whereNull("deleted_at")->where("user_id", $user->id)->get();
            foreach($chatRooms as $chatRoom) {
                try {
                    $con->destroy($chatRoom->id);
                } catch(\Exception $e) {
                    continue;
                }
            }
        }

        //削除するユーザーに紐づいてるチャットルーム-ユーザー中間テーブルを削除
        $chatRoomUsers = ChatRoom__User::where("user_id", $user->id)->delete();
        

        $user->fill(['delete_user_id' => Auth::id(), 'deleted_at' => $now])->save();
        return redirect()->route('user.index');
    }
}
