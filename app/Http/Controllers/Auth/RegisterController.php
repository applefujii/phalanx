<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Office;
use App\Models\ChatRoom;
use App\Models\ChatRoom__User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\IdentiferRule;
use App\Rules\KatakanaRule;
use App\Rules\AsciiRule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('staff');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_type_id' => ['required', 'exists:user_types,id'],
            'office_id' => ['required', 'exists:offices,id'],
            'name' => ['required', 'string', 'max:255'],
            'name_katakana' => ['required', 'string', 'max:255', new KatakanaRule],
            'login_name' => ['required', 'string', new IdentiferRule, 'min:3', 'max:30', Rule::unique('users', 'login_name')->whereNull('deleted_at')],
            'password' => ['required', 'string', new AsciiRule, 'min:8', 'max:30', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $now = Carbon::now();
        return User::create([
            'user_type_id' => $data['user_type_id'],
            'office_id' => $data['office_id'],
            'name' => $data['name'],
            'name_katakana' => $data['name_katakana'],
            'login_name' => $data['login_name'],
            'password' => Hash::make($data['password']),
            'create_user_id' => Auth::id(),
            'update_user_id' => Auth::id(),
            'created_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
            'updated_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //現在時刻を取得
        $now = carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        //作成されたユーザーが職員の場合職員全体と対利用者のチャットルームに自動的に参加
        if($user->user_type_id == 1) {
            $group = ChatRoom::where("distinction_number", 0)->first();
            $chatRoomUser = new ChatRoom__User();
            $chatRoomUser->chat_room_id = $group->id;
            $chatRoomUser->user_id = $user->id;
            $chatRoomUser->create_user_id = Auth::id();
            $chatRoomUser->update_user_id = Auth::id();
            $chatRoomUser->created_at = $now;
            $chatRoomUser->updated_at = $now;
            $chatRoomUser->save();

            $chatRooms = ChatRoom::whereNull("deleted_at")->where("distinction_number", 3)->where("office_id", $user->office_id)->get();
            foreach($chatRooms as $chatRoom) {
                $chatRoomUser = new ChatRoom__User();
                $chatRoomUser->chat_room_id = $chatRoom->id;
                $chatRoomUser->user_id = $user->id;
                $chatRoomUser->create_user_id = Auth::id();
                $chatRoomUser->update_user_id = Auth::id();
                $chatRoomUser->created_at = $now;
                $chatRoomUser->updated_at = $now;
                $chatRoomUser->save();
            }
        
        //ユーザー以外の場合職員対利用者のチャットルームを作成
        } else {
            $offices = Office::whereNull("deleted_at")->get();
            foreach($offices as $office) {
                $chatRoom = new ChatRoom();
                $chatRoom->room_title = $user->name;
                $chatRoom->distinction_number = 3;
                $chatRoom->office_id = $office->id;
                $chatRoom->user_id = $user->id;
                $chatRoom->create_user_id = Auth::id();
                $chatRoom->update_user_id = Auth::id();
                $chatRoom->created_at = $now;
                $chatRoom->updated_at = $now;
                $chatRoom->save();

                $chatRoomUser = new ChatRoom__User();
                $chatRoomUser->chat_room_id = $chatRoom->id;
                $chatRoomUser->user_id = $user->id;
                $chatRoomUser->create_user_id = Auth::id();
                $chatRoomUser->update_user_id = Auth::id();
                $chatRoomUser->created_at = $now;
                $chatRoomUser->updated_at = $now;
                $chatRoomUser->save();

                $officers = User::whereNull("deleted_at")->where("user_type_id", 1)->where("office_id", $office->id)->get();
                foreach($officers as $officer) {
                    $chatRoomUser = new ChatRoom__User();
                    $chatRoomUser->chat_room_id = $chatRoom->id;
                    $chatRoomUser->user_id = $officer->id;
                    $chatRoomUser->create_user_id = Auth::id();
                    $chatRoomUser->update_user_id = Auth::id();
                    $chatRoomUser->created_at = $now;
                    $chatRoomUser->updated_at = $now;
                    $chatRoomUser->save();
                }
            }
        }

        // $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }

    public function register_return_id(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        return $user->id;
    }

    public function showRegistrationForm()
    {
        return redirect()->route('user.create');
    }
}
