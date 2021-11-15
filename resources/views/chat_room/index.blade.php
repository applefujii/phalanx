@extends("chat_room.sidebar")
@section("c_css")

@endsection

@section('center')
<div class="container-fluid pt-3">
    <h3>通所者一覧</h3>
    <div class="d-flex flex-column text-center">
        @foreach ($offices as $office)
            @if ($office->id == Auth::user()->office_id)
                <div class="d-flex flex-column">
                    <div>
                        ───<button type="button" class="btn btn-link offices-open" data-toggle="collapse" data-target="#{{ $office->en_office_name }}Collapse" aria-expanded="true">
                            <i class="fas fa-chevron-up"></i>{{ $office->office_name }}
                        </button>───
                    </div>
                    <div class="collapse show" id="{{ $office->en_office_name }}Collapse">
                        @foreach ($userRooms as $userRoom)
                            @if ($userRoom->user->user_type_id == 2 && $userRoom->user->office_id == $office->id)
                                <div class="col-6 col-md-4 col-xl-3">
                                    <a href="{{ route('chat.index', $userRoom->id) }}">{{ $userRoom->room_title }}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="d-flex flex-column">
                    <div>
                        ───<button type="button" class="btn btn-link offices-open" data-toggle="collapse" data-target="#{{ $office->en_office_name }}Collapse" aria-expanded="false">
                            <i class="fas fa-chevron-down"></i>{{ $office->office_name }}
                        </button>───
                    </div>
                    <div class="collapse" id="{{ $office->en_office_name }}Collapse">
                        @foreach ($userRooms as $userRoom)
                            @if ($userRoom->user->user_type_id == 2 && $userRoom->user->office_id == $office->id)
                                <div class="col-6 col-md-4 col-xl-3">
                                    <a href="{{ route('chat.index', $userRoom->id) }}">{{ $userRoom->room_title }}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        <div class="d-flex flex-column">
            <div>
                ───<button type="button" class="btn btn-link offices-open" data-toggle="collapse" data-target="#trialsCollapse" aria-expanded="false">
                    <i class="fas fa-chevron-down"></i>体験
                </button>───
                <div class="collapse" id="trialsCollapse">
                    @foreach ($userRooms as $userRoom)
                        @if ($userRoom->user->user_type_id == 3)
                            <div class="col-6 col-md-4 col-xl-3">
                                <a href="{{ route('chat.index', $userRoom->id) }}">{{ $userRoom->room_title }}</a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div is="script">
    $(function() {

        //.offices-openが押された時の動作
        $(".offices-open").click(function(){
            let fas = $(this).find(".fas");
            if( fas.hasClass("fa-chevron-down") ) {
                fas.removeClass("fa-chevron-down");
                fas.addClass("fa-chevron-up");
            } else {
                fas.removeClass("fa-chevron-up");
                fas.addClass("fa-chevron-down");
            }
        });
    });
</div>
@endsection