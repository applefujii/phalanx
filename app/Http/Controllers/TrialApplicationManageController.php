<?php
/**
 * 体験・見学申込管理のコントローラー
 *
 * @author Fumio Mochizuki
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Office;
use App\Models\TrialApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TrialApplicationRequest;
use App\Http\Requests\TrialApplicationSearchRequest;
use Carbon\Carbon;

class TrialApplicationManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\TrialApplicationSearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(TrialApplicationSearchRequest $request)
    {
        $office_id = $request->input('office_id');
        $check_done = $request->input('check_done');
        $check_yet = $request->input('check_yet');

        $trial_applications = TrialApplication::when($office_id, function ($query) use ($office_id) {
                return $query->where('office_id', $office_id);
            })
            ->when($check_done, function ($query) {
                return $query->where('is_checked', true);
            })
            ->when($check_yet, function ($query) {
                return $query->where('is_checked', false);
            })
            ->paginate(config('const.pagination'));
        
        $offices = Office::whereNotNull('deleted_at')->get();

        return view('trial_application/index', compact("offices", "office_id", "check_done", "check_yet", "trial_applications"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('trial_application/edit');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check($id)
    {
        return view('trial_application/check');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check_update(Request $request, $id)
    {
        //
    }
}
