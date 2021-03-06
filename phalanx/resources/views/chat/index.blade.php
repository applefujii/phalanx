@extends("chat.sidebar2")
@section("title", "通所者一覧")
@section("c_css")
<link href="{{ asset('css/chat_index.css') }}" rel="stylesheet">
@endsection

@section('center')
<div class="scroll-contents" id="center-scroll">
    <div class="container-fluid pt-3 mb-5">
        <h3>通所者一覧</h3>
        <div class="d-flex flex-column">
            @foreach ($offices as $office_index => $office)
                <div class="d-flex flex-column @if($office->id == Auth::user()->office_id) order-0 @else order-{{ $office_index+1 }} @endif">
                    <div class="my-2 position-relative">
                        <hr color="black" width="100%">
                        <p class="d-flex align-items-center collapse-open">
                            <input type="checkbox" class="mx-2 {{ $office->en_office_name }}-allCheck">
                            <button type="button" class="btn btn-link offices-open" data-toggle="collapse" data-target="#{{ $office->en_office_name }}Collapse" aria-expanded="@if ($office->id == Auth::user()->office_id)true @else false @endif">
                                {{ $office->office_name }}<i class="fas @if ($office->id == Auth::user()->office_id)fa-chevron-up @else fa-chevron-down @endif"></i>
                            </button>
                        </p>
                    </div>
                    <div class="collapse row @if ($office->id == Auth::user()->office_id)show @endif" id="{{ $office->en_office_name }}Collapse">
                        @foreach (
                            $join_chat_rooms->where("office_id", Auth::user()->office_id)->whereNotNull("user_id")->sortBy('user.name_katakana')
                                 as $join_chat_room
                            )
                            @if (optional($join_chat_room->user)->user_type_id == 2 && $join_chat_room->user->office_id == $office->id)
                                <div class="col-6 col-md-4 col-xl-3 my-1 d-flex align-items-center">
                                    <input type="checkbox" class="mr-1 {{ $office->en_office_name }}-checkBox" name="user" value="{{ $join_chat_room->id }}">
                                    <a class="chat_room_{{ $join_chat_room->id }} chat-room-link" href="{{ route('chat.show', $join_chat_room->id) }}">
                                        <span class="new d-none">●</span>{{ $join_chat_room->room_title }}
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
            <div class="d-flex flex-column order-12">
                <div class="my-2 position-relative">
                    <hr color="black" width="100%">
                    <p class="d-flex align-items-center collapse-open">
                        <input type="checkbox" class="mx-2 trial-allCheck">
                        <button type="button" class="btn btn-link offices-open" data-toggle="collapse" data-target="#trialsCollapse" aria-expanded="false">
                            体験<i class="fas fa-chevron-down"></i>
                        </button>
                    </p>
                </div>
                <div class="collapse text-left row" id="trialsCollapse">
                    @foreach (
                            $join_chat_rooms->where("office_id", Auth::user()->office_id)->whereNotNull("user_id")->where("user.user_type_id", 3)
                                ->sort(function($first, $second) {
                                    if($first->user->office->sort == $second->user->office->sort) {
                                        return $first->user->name_katakana > $second->user->name_katakana ? 1 : -1;
                                    }
                                    return $first->user->office->sort > $second->user->office->sort ? 1 : -1;
                                }) as $join_chat_room
                        )
                        <div class="col-6 col-md-4 col-xl-3 my-1 d-flex align-items-center">
                            <input type="checkbox" class="mr-1 trial-checkBox" name="user" value="{{ $join_chat_room->id }}">
                            <a class="chat_room_{{ $join_chat_room->id }} chat-room-link" href="{{ route('chat.show', $join_chat_room->id) }}">
                                <span class="new d-none">●</span>{{ $join_chat_room->room_title }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="text-danger position-fixed" id="errorMessage">正しく送信できませんでした。</div>
        @endif
        <button type="button" class="btn btn-primary position-fixed broadcast" data-toggle="modal" data-target="#broadcastModal">一斉送信</button>
    </div>
</div>

<div class="modal fade" id="broadcastModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">一斉送信</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="mx-md-5 my-2" action="{{ route('chat.multiStore') }}" method="post">
                    @csrf
                    <input type="hidden" name="chat_rooms" id="chatRoomsValue">
                    <div class="form-group">
                        <label for="chatText" class="sr-only">チャットテキスト</label>
                        <textarea class="form-control" name="chat_text" id="chatText" cols="40" rows="5" placeholder="テキスト"></textarea>
                    </div>
                    <div class="text-right">
                        <div class="text-danger mr-2 d-none" id="notSelect">※送信先を選んでいません</div>
                        <button class="btn btn-primary mt-1" id="broadcastSubmit" type="submit">一斉送信</button>
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
            fas.toggleClass("fa-chevron-down");
            fas.toggleClass("fa-chevron-up");
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
            let notSelect = $("#notSelect");
            let broadcastSubmit = document.getElementById("broadcastSubmit");
            if(!rooms.length) {
                if(notSelect.hasClass("d-none")) {
                    notSelect.removeClass("d-none");
                }
                if(broadcastSubmit.disabled == false) {
                    broadcastSubmit.disabled = true;
                }
            } else {
                if(!notSelect.hasClass("d-none")) {
                    notSelect.addClass("d-none");
                }
                if(broadcastSubmit.disabled) {
                    broadcastSubmit.disabled = false;
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