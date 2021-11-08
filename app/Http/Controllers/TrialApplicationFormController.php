<?php
/**
 * 体験・見学申込フォームのコントローラー
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

class TrialApplicationFormController extends Controller
{
    /**
     * 申込フォーム
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offices = Office::whereNull('deleted_at')->orderBy('sort')->get();
        // office_idは適性診断画面から渡される
        $office_id = $request->input('office_id');
        return view('trial_application_form/form', compact('offices', 'office_id'));
    }

    /**
     * 申込フォームの内容をDBに保存
     *
     * @param  \App\Http\Requests\TrialApplicationSearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrialApplicationRequest $request)
    {
        $now = Carbon::now();
        $desired_date = new Carbon($request->input('desired_date'));

        $trial_application = new TrialApplication();
        $trial_application->name = Crypt::encryptString($request->input('name'));
        $trial_application->name_kana = Crypt::encryptString($request->input('name_kana'));
        $trial_application->office_id = $request->input('office_id');
        $trial_application->desired_date = $request->input('desired_date');
        $trial_application->email = Crypt::encryptString($request->input('email'));
        $trial_application->phone_number = Crypt::encryptString($request->input('phone_number'));
        $trial_application->created_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $trial_application->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $trial_application->save();

        return redirect()->route('trial_application_form.finish');
    }

    /**
     * 申込が完了しました画面
     *
     * @return \Illuminate\Http\Response
     */
    public function finish()
    {
        return view('trial_application_form/finish');
    }
}
