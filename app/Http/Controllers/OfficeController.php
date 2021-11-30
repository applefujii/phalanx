<?php
/**
 * 事業所マスタのコントローラー
 *
 * @author Yubaru Nozato
 */


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
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
     * 新規データ作成の実行部分
     */
    public function store(Request $request)
    {
        $request->validate([
            'office_name' => 'required|unique:offices,office_name',
            'sort' => 'required|unique:offices,sort'
        ],
        [
            'office_name.required' => '事業所名を入力してください。',
            'sort.required' => '表示する順番を数字で入力してください。',
            'office_name.unique' => 'その事業所は既に登録されています。',
            'sort.unique' => 'その番号は既に登録されています。'
     ]);


        //ログイン中のユーザーデータを取得
        $user = Auth::user();

        //各種リクエストのデータを取得
        $officename = $request->input("office_name");
        $sort = $request->input("sort");

        //現在時刻の取得
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        //Officeインスタンスを作成、各種データを挿入後登録
        $office = new Office();
        $office->office_name = $officename;
        $office->sort = $sort;
        $office->create_user_id = isset($user->id);
        $office->update_user_id = isset($user->id);
        $office->created_at = $now;
        $office->updated_at = $now;
        $office->save();
        return redirect()->route("office.index");
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
     * データ編集の実行部分
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'office_name' => ['required',Rule::unique('offices')->ignore($id)],
            'sort' => ['required',Rule::unique('offices')->ignore($id)]
        ],
        [
            'office_name.required' => '事業所名を入力してください。',
            'sort.required' => '表示する順番を数字で入力してください。',
            'office_name.unique' => 'その事業所は既に登録されています。',
            'sort.unique' => 'その番号は既に登録されています。'
     ]);

        //ログイン中のユーザーデータを取得
        $user = Auth::user();

        //各種リクエストのデータを取得
        $officename = $request->input("office_name");
        $sort = $request->input("sort");

    //現在時刻を取得
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        $office = Office::findOrFail($id);
        $office->office_name = $officename;
        $office->sort = $sort;
        $office->update_user_id = $user->id;
        $office->updated_at = $now;
        $office->save();
        return redirect()->route("office.index");
    }

    /**
     * データ削除の実行部分
     */
    public function destroy($id)
    {
        //ログイン中のユーザーデータを取得
        $user = Auth::user();

        //現在時刻を取得
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        //削除を実行
        $office = Office::findOrFail($id);
        $office->delete();
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
