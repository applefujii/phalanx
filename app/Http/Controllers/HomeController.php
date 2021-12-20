<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrialApplication;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index()
    {
        //-- 古い通知を消す
        $dt = new \DateTime( "now" );
        Notification::whereRaw( "end_at <= DATE_SUB( CURDATE(),INTERVAL 1 DAY )" )->update([
            'deleted_at' => $dt->format('Y-m-d H:i:s')
        ]);
        
        // 体験申込の新規チェック
        $trial_applications = TrialApplication::whereNull('deleted_at')->where('office_id', Auth::user()->office_id)->where('is_checked', false)->get();
        $new_trial_applications = $trial_applications->isNotEmpty();

        // 通知の獲得
        $notifications = Notification::whereNull('deleted_at')->whereHas('notification__user', function($n__u) {
            $n__u->where('user_id', '=', Auth::id());
        })->orderBy('start_at', 'asc')->orderBy('end_at', 'asc')->get();
        $notifications_groups = $notifications->mapToGroups(function ($notification, $key) {
            $start_at = new Carbon($notification->start_at);
            $end_at = new Carbon($notification->end_at);
            $now = now();
            $end_of_week = now()->endOfWeek();
            $end_of_month = now()->endOfMonth();
            $end_of_year = now()->endOfYear();
            if ($end_at < $now) {
                return ['期限切れ' => $notification];
            } else if ($start_at <= $now && $now <= $end_at) {
                return ['現在' => $notification];
            } else if ($start_at->isToday()) {
                return ['本日' => $notification];
            } else if ($start_at <= $end_of_week) {
                return ['今週' => $notification];
            } else if ($start_at <= $end_of_month) {
                return ['今月' => $notification];
            } else if ($start_at <= $end_of_year) {
                return ['今年' => $notification];
            } else if ($start_at > $end_of_year) {
                return ['来年以降' => $notification];
            } else {
                return ['不明' => $notification];
            }
        });
        return view("home", compact('new_trial_applications', 'notifications_groups'));
    }
}
