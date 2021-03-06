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
        //-- 古い通知を消す
        $dt = new \DateTime( "now" );
        Notification::whereDate("end_at", "<", $dt->format('Y-m-d'))->update([
            'deleted_at' => $dt->format('Y-m-d H:i:s')
        ]);
        
        // 体験申込の新規チェック
        $trial_applications = TrialApplication::whereNull('deleted_at')->where('office_id', Auth::user()->office_id)->where('is_checked', false)->get();
        $new_trial_applications = $trial_applications->isNotEmpty();

        // チャットに未読があるかチェック
        $con = app()->make("App\Http\Controllers\ChatController");
        $exist_unread = $con->ExistUnread(new Request());

        // 通知の獲得
        $notifications = Notification::whereHas('notification__user', function($n__u) {
            $n__u->where('user_id', '=', Auth::id());
        })->orWhere(function($query) {
            $query->whereHas('notification__office', function($n__o) {
                    if( Auth::user()->user_type_id == 3 ) {
                    $n__o->where('office_id', '=', 0);
                } else {
                    $n__o->where('office_id', '=', Auth::user()->office_id);
                }
            });
        })->whereNull('deleted_at')->orderBy('start_at', 'asc')->orderBy('end_at', 'asc')->get();
        $unsorted_notifications_groups = $notifications->mapToGroups(function ($notification, $key) {
            $start_at = new Carbon($notification->start_at);
            $end_at = new Carbon($notification->end_at);
            $now = now();
            $end_of_week = now()->endOfWeek();
            $end_of_month = now()->endOfMonth();
            $end_of_year = now()->endOfYear();
            if ($start_at <= $end_of_week) {
                return ['今週' => $notification];
            } else {
                return ['来週以降' => $notification];
            }
        });
        // ソート用
        $key_order = [
            '今週' => 1,
            '来週以降' => 2,
        ];
        $notifications_groups = $unsorted_notifications_groups->sortBy(function ($notification, $key) use ($key_order) {
            if (array_key_exists($key, $key_order)) {
                return $key_order[$key];
            } else {
                return PHP_INT_MAX;
            }
        });
        return view("user_page2", compact('new_trial_applications', 'notifications_groups', 'exist_unread'));
    }
}