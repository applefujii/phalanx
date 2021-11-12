<?php
/**
 * 体験・見学申込管理のコントローラー
 *
 * @author Fumio Mochizuki
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Office;
use App\Models\TrialApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TrialApplicationRequest;
use App\Http\Requests\TrialApplicationSearchRequest;
use Carbon\Carbon;

class TrialApplicationManageController extends Controller
{
    // 権限チェック
    public function __construct()
    {
        $this->middleware('staff');// 職員
    }

    /**
     * 一覧画面
     *
     * @param  \App\Http\Requests\TrialApplicationSearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(TrialApplicationSearchRequest $request)
    {
        $office_id = $request->input('office_id');
        $check_done = $request->input('check_done');
        $check_yet = $request->input('check_yet');

        $trial_applications = TrialApplication::whereNull('deleted_at')
        ->with('office')
            ->when($office_id, function ($query) use ($office_id) {
                return $query->where('office_id', $office_id);
            })
            ->where(function($query) use($check_done, $check_yet) {
                $query->when($check_done, function ($query) {
                    return $query->orWhere('is_checked', true);
                });
                $query->when($check_yet, function ($query) {
                    return $query->orWhere('is_checked', false);
                });
            })
            ->orderBy('is_checked')
            ->orderByDesc('created_at')
            ->orderBy('desired_date')
            ->orderBy('office_id')
            ->paginate(config('const.pagination'));
        
        $offices = Office::whereNull('deleted_at')->orderBy('sort')->get();

        return view('trial_application_manage/index', compact('offices', 'office_id', 'check_done', 'check_yet', 'trial_applications'));
    }

    /**
     * 編集画面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trial_application = TrialApplication::findOrFail($id);

        $offices = Office::whereNull('deleted_at')->orderBy('sort')->get();
        return view('trial_application_manage/edit', compact('offices', 'trial_application'));
    }

    /**
     * 編集画面の内容をDBに保存
     *
     * @param  \App\Http\Requests\TrialApplicationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TrialApplicationRequest $request, $id)
    {
        $now = Carbon::now();
        $trial_application = TrialApplication::findOrFail($id);
        
        $trial_application->name = Crypt::encryptString($request->input('name'));
        $trial_application->name_kana = Crypt::encryptString($request->input('name_kana'));
        $trial_application->office_id = $request->input('office_id');
        $trial_application->desired_date = $request->input('desired_date');
        $trial_application->email = Crypt::encryptString($request->input('email'));
        $trial_application->phone_number = Crypt::encryptString($request->input('phone_number'));
        $trial_application->update_user_id = Auth::user()->id;
        $trial_application->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $trial_application->save();
        return redirect()->route('trial_application_manage.index');
    }

    /**
     * DBから論理削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $now = Carbon::now();
        $trial_application = TrialApplication::findOrFail($id);

        $trial_application->update_user_id = Auth::user()->id;
        $trial_application->delete_user_id = Auth::user()->id;
        $trial_application->deleted_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $trial_application->save();
        return redirect()->route('trial_application_manage.index');
    }

    /**
     * 確認画面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check($id)
    {
        $trial_application = TrialApplication::findOrFail($id);

        $offices = Office::whereNull('deleted_at')->orderBy('sort')->get();
        return view('trial_application_manage/check', compact('offices', 'trial_application'));
    }

    /**
     * DBに確認済という結果を保存または確認未に戻す
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check_update(Request $request, $id)
    {
        $now = Carbon::now();
        $trial_application = TrialApplication::findOrFail($id);

        $trial_application->is_checked = !$trial_application->is_checked;
        $trial_application->update_user_id = Auth::user()->id;
        $trial_application->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $trial_application->save();
        return redirect()->route('trial_application_manage.index');
    }
}
