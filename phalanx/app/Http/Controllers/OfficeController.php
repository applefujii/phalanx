<?php
/**
 * 事業所マスタのコントローラー
 *
 * @author Yubaru Nozato
 */


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\ChatRoom;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OfficeRequest;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
     /**
     * コンストラクタ
     */

/**
     * 事業所マスタ表示画面
     */
    public function index()
    {
        $offices = Office::orderBy("id")->get();
        return view("office_master/index",compact("offices"));
    }

     /**
     * 新規データの作成
     */
    public function create()
    {
        $offices = Office::orderBy("id")->get();
        return view("office_master/create",compact("offices"));
    }

     /**
     * 新規データ作成の受け取り部分
     */
    public function store(OfficeRequest $request)
    {
        $id = $this->storeDetail($request);

        return redirect()->route("office.index");
    }

    /**
     * 新規データ作成の実行部分
     * 
     * @param Request $request
     * @return int $id
     */
    public function storeDetail(Request $request) {

        $office = null;
        DB::transaction(function () use(&$office, $request) {
            $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
            $office = Office::create([
                "office_name" => $request->input("office_name"),
                "en_office_name" => $request->input("en_office_name"),
                "sort" => $request->input("sort"),
                "create_user_id" => Auth::id(),
                "update_user_id" => Auth::id(),
                "created_at" => $now,
                "update_at" => $now,
            ]);

            $con = app()->make("App\Http\Controllers\ChatRoomController");
            $id = $con->storeDetail(new Request([
                "room_title" => $office->office_name . "職員",
                "distinction_number" => 1,
                "office_id" => $office->id,
            ]));
        });

        if(isset($office)) return $office->id;
        return -1;
    }


    /**
     * データの編集
     */
    public function edit($id)
    {
        //編集するデータを取得
        $office = Office::findOrFail($id);
        return view("office_master/edit", compact("office"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * データ編集の受け取り部分
     */
    public function update(OfficeRequest $request, $id)
    {
        $id = $this->updateDetail($request, $id);

        return redirect()->route("office.index");
    }

    /**
     * データ更新の実行部分
     * 
     * @param Request $request, int $id
     * @return int $id
     */
    public function updateDetail(Request $request, $id) {

        $office = null;
        DB::transaction(function () use(&$office, $request, $id) {
            $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
            $office = Office::whereNull("deleted_at")->where("id", $id)->first();

            if(isset($office)) {
                $office->update([
                    "office_name" => $request->input("office_name"),
                    "en_office_name" => $request->input("en_office_name"),
                    "sort" => $request->input("sort"),
                    "update_user_id" => Auth::id(),
                    "updated_at" => $now
                ]);

                ChatRoom::whereNull("deleted_at")->where("distinction_number", 1)->where("office_id", $office->id)->update([
                    "room_title" => $office->office_name . "職員",
                    "update_user_id" => Auth::id(),
                    "updated_at" => $now
                ]);
            }
        });

        if(isset($office)) return $id;
        return -1;
    }

    /**
     * データ削除の実行部分
     */
    public function destroy($id)
    {
        DB::transaction(function () use($id) {
            $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
            $office = whereNull("deleted_at")->where("id", $id);

            if(isset($office)) {
                $office->update([
                    "delete_user_id" => Auth::id(),
                    "deleted_at" => $now
                ]);

                $con = app()->make("App\Http\Controllers\ChatRoomController");
                $chatRoom = ChatRoom::whereNull("deleted_at")->where("distinction_number", 1)->where("office_id", $office->id)->first();
                $con->destroy($chatRoom->id);
            }
        });

        return redirect()->route("office.index");
    }

    public function messages()
    {
        return [
            'office_name.required' => 'A title is required',
            'sort.required'  => 'A message is required',
        ];
    }
}
