@extends("chat_room.sidebar")
@section("c_css")
<link href="{{ asset('css/chat_room_index.css') }}" rel="stylesheet">
@endsection

@section('center')
<div class="container-fluid pt-3 mb-5">
    <h3>通所者一覧</h3>
    <div class="d-flex flex-column text-center">
        @foreach ($offices as $office)
            @if ($office->id == Auth::user()->office_id)
                <div class="d-flex flex-column">
                    <div class="my-2">
                        ───<input type="checkbox" class="mx-1 {{ $office->en_office_name }}-allCheck">
                        <button type="button" class="btn btn-link offices-open" data-toggle="collapse" data-target="#{{ $office->en_office_name }}Collapse" aria-expanded="true">
                            <i class="fas fa-chevron-up"></i>{{ $office->office_name }}
                        </button>───
                    </div>
                    <div class="collapse show text-left row" id="{{ $office->en_office_name }}Collapse">
                        @foreach ($userRooms as $userRoom)
                            @if ($userRoom->user->user_type_id == 2 && $userRoom->user->office_id == $office->id)
                                <div class="col-6 col-md-4 col-xl-3">
                                    <input type="checkbox" class="mr-1 {{ $office->en_office_name }}-checkBox" name="user" value="{{ $userRoom->user_id }}">
                                    <a href="{{ route('chat.index', $userRoom->id) }}">{{ $userRoom->room_title }}</a>
                                </div>
                            @endif
                        @endforeach
                        @for ($i = 0; $i < 10; $i++)
                            <div class="col-6 col-md-4 col-xl-3">
                                <input type="checkbox" class="mr-1 apple-checkBox" name="user" value="{{ $i + 1 }}">
                                <a href="">aaaaa</a>
                            </div>
                        @endfor
                    </div>
                </div>
            @else
                <div class="d-flex flex-column">
                    <div class="my-2">
                        ───<input type="checkbox" class="mx-1 {{ $office->en_office_name }}-allCheck">
                        <button type="button" class="btn btn-link offices-open" data-toggle="collapse" data-target="#{{ $office->en_office_name }}Collapse" aria-expanded="false">
                            <i class="fas fa-chevron-down"></i>{{ $office->office_name }}
                        </button>───
                    </div>
                    <div class="collapse text-left row" id="{{ $office->en_office_name }}Collapse">
                        @foreach ($userRooms as $userRoom)
                            @if ($userRoom->user->user_type_id == 2 && $userRoom->user->office_id == $office->id)
                                <div class="col-6 col-md-4 col-xl-3">
                                    <input type="checkbox" class="mr-1 {{ $office->en_office_name }}-checkBox" name="user" value="{{ $userRoom->user_id }}">
                                    <a href="{{ route('chat.index', $userRoom->id) }}">{{ $userRoom->room_title }}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        <div class="d-flex flex-column">
            <div class="my-2">
                ───<input type="checkbox" class="mx-1 trial-allCheck">
                <button type="button" class="btn btn-link offices-open" data-toggle="collapse" data-target="#trialsCollapse" aria-expanded="false">
                    <i class="fas fa-chevron-down"></i>体験
                </button>───
            </div>
            <div class="collapse text-left row" id="trialsCollapse">
                @foreach ($userRooms as $userRoom)
                    @if ($userRoom->user->user_type_id == 3)
                        <div class="col-6 col-md-4 col-xl-3">
                            <input type="checkbox" class="mr-1 trial-checkBox" name="user" value="{{ $userRoom->user_id }}">
                            <a href="{{ route('chat.index', $userRoom->id) }}">{{ $userRoom->room_title }}</a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary position-fixed broadcast" data-toggle="modal" data-target="#broadcastModal">一斉送信</button>
</div>
@endsection

@section('c_modal')
<div class="modal fade modal-lg" id="broadcastModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form class="mx-5 my-2" action="#" method="post">
                    @csrf
                    <input type="hidden" name="chat-rooms" id="chatRoomsValue">
                    <div class="form-group">
                        <label for="chatText" class="sr-only">チャットテキスト</label>
                        <textarea class="form-control" name="chat-text" id="chatText" cols="40" rows="5" placeholder="テキスト"></textarea>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary mt-1" type="submit">一斉送信</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("c_script")
<script>
    $(function() {

        //.offices-openが押された時の動作
        $(".offices-open").click(function() {
            let fas = $(this).find(".fas");
            if( fas.hasClass("fa-chevron-down") ) {
                fas.removeClass("fa-chevron-down");
                fas.addClass("fa-chevron-up");
            } else {
                fas.removeClass("fa-chevron-up");
                fas.addClass("fa-chevron-down");
            }
        });

        //一斉送信ボタンが押されたとき
        $(".broadcast").click(function() {
            let roomsList = document.getElementsByName("user");
            let rooms = [];
            for (let i = 0; i < roomsList.length; i ++) {
                if(roomsList[i].checked == true) {
                    rooms.push(roomsList[i].value);
                }
            }
            document.getElementById("chatRoomsValue").value = rooms.join();
        });

        //事務所ごとに各種動作を作成
        @foreach ($offices as $office)

            //現在のチェック数を保存する変数
            let {{ $office->en_office_name }}CheckCount = 0;

            //すべてチェックが押されたとき
            $(".{{ $office->en_office_name }}-allCheck").click(function() {
                if($(this).prop("checked") != true) {
                    $(".{{ $office->en_office_name }}-checkBox").each(function() {
                        if($(this).prop("checked") == true) {
                            $(this).prop("checked", false);
                            {{ $office->en_office_name }}CheckCount --;
                        }
                    });
                } else {
                    $(".{{ $office->en_office_name }}-checkBox").each(function() {
                        if($(this).prop("checked") != true) {
                            $(this).prop("checked", true);
                            {{ $office->en_office_name }}CheckCount ++;
                        }
                    });
                }
            });

            //個別チェックが押されたとき
            $(".{{ $office->en_office_name }}-checkBox").click(function() {
                if($(this).prop("checked") == true) {
                    {{ $office->en_office_name }}CheckCount ++;
                    if({{ $office->en_office_name }}CheckCount == $(".{{ $office->en_office_name }}-checkBox").length) {
                        $(".{{ $office->en_office_name }}-allCheck").prop("checked", true);
                    }
                } else {
                    {{ $office->en_office_name }}CheckCount --;
                    if({{ $office->en_office_name }}CheckCount != $(".{{ $office->en_office_name }}-checkBox").length) {
                        $(".{{ $office->en_office_name }}-allCheck").prop("checked", false);
                    }
                }
            });
        @endforeach

        //体験者の各種動作
        //現在のチェック数を保存する変数
        let trialCheckCount = 0;

        //すべてチェックが押されたとき
        $(".trial-allCheck").click(function() {
            if($(this).prop("checked") != true) {
                $(".trial-checkBox").each(function() {
                    if($(this).prop("checked") == true) {
                        $(this).prop("checked", false);
                        trialCheckCount --;
                    }
                });
            } else {
                $(".trial-checkBox").each(function() {
                    if($(this).prop("checked") != true) {
                        $(this).prop("checked", true);
                        trialCheckCount ++;
                    }
                });
            }
        });

        //個別チェックが押されたとき
        $(".trial-checkBox").click(function() {
            if($(this).prop("checked") == true) {
                trialCheckCount ++;
                if(trialCheckCount == $(".trial-checkBox").length) {
                    $(".trial-allCheck").prop("checked", true);
                }
            } else {
                trialCheckCount --;
                if(trialCheckCount != $(".trial-checkBox").length) {
                    $(".trial-allCheck").prop("checked", false);
                }
            }
        });
    });
</script>
@endsection