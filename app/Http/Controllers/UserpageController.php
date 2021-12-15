<?php

/**
 * ログイン後に表示するページのコントローラ
 * 
 * @author Yubaru Nozato
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrialApplication;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserpageController extends Controller
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



    public function index()
    {
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
                return ['今' => $notification];
            } else if ($start_at->isToday()) {
                return ['今日' => $notification];
            } else if ($start_at <= $end_of_week) {
                return ['今週' => $notification];
            } else if ($start_at <= $end_of_month) {
                return ['今月' => $notification];
            } else if ($start_at <= $end_of_year) {
                return ['今年' => $notification];
            } else if ($start_at > $end_of_year) {
                return ['来年以降' => $notification];
            } else {
                return ['unknown' => $notification];
            }
        });
        return view("user_page", compact('new_trial_applications', 'notifications_groups'));
    }
}