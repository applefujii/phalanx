@if (Auth::user()->user_type_id == 1)
    <div class="row p-3">
        <a href="{{ route('chat.index') }}" class="btn btn-primary btn-lg btn-block" role="button">通所者一覧</a>
    </div>
@endif
<div class="row">
    @if ($join_chat_rooms->where("distinction_number", 0)->isNotEmpty())
        <div class="col-12 pt-3">
            <h5>リテラル</h5>
            <ul class="col-12 pt-1">
                <li><a href="{{ route("chat.show", $join_chat_rooms->where("distinction_number", 0)->first()->id) }}" class="{{ $join_chat_rooms->where("distinction_number", 0)->first()->id }}">
                    全職員
                </a></li>
            </ul>
        </div>
    @endif
    @if ($join_chat_rooms->where("distinction_number", 4)->where("office_id", 0)->isNotEmpty())
        <div class="col-12 pt-3">
            <h5>その他</h5>
            <ul class="col-12 pt-1">
                @foreach ($join_chat_rooms->where("distinction_number", 4)->where("office_id", 0) as $join_chat_room)
                    <li>
                        <a id="chat_room_{{ $join_chat_room->id }}" href="{{ route('chat.show', $join_chat_room->id) }}">
                        {{ $join_chat_room->room_title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @foreach ($offices as $office)
        @if ($office->id == Auth::user()->office_id)
            <div class="col-12 pt-3">
                <h5>{{ $office->office_name }}</h5>
                <ul class="col-12 pt-1">
                    @if (Auth::user()->user_type_id === 1)
                        @foreach ($join_chat_rooms->whereIn("distinction_number", [1, 4]) as $join_chat_room)
                            @if ($join_chat_room->office_id == $office->id)
                                <li>
                                    <a id="chat_room_{{ $join_chat_room->id }}" href="{{ route('chat.show', $join_chat_room->id) }}">
                                    @if ($join_chat_room->distinction_number == 4){{ $join_chat_room->room_title }} @else {{ $office->office_name }}職員 @endif
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @else
                        @foreach ($join_chat_rooms->whereIn("distinction_number", [3, 4]) as $join_chat_room)
                            @if ($join_chat_room->office_id == $office->id)
                                <li>
                                    <a id="chat_room_{{ $join_chat_room->id }}" href="{{ route('chat.show', $join_chat_room->id) }}">
                                    @if ($join_chat_room->distinction_number == 4){{ $join_chat_room->room_title }} @else {{ $office->office_name }}職員 @endif
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
        @endif
    @endforeach
    <div class="col-12 px-0">
        <div>
            <button type="button" class="btn btn-outline-dark btn-block sub-offices" data-toggle="collapse" data-target="#subOffices" aria-expanded="false" aria-controls="subOffices">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        <div class="collapse" id="subOffices">
            @foreach ($offices as $office)
                @if ($office->id != Auth::user()->office_id)
                    <div class="col-12 pt-3">
                        <h5>{{ $office->office_name }}</h5>
                        <ul class="col-12 pt-1">
                            @if (Auth::user()->user_type_id === 1)
                                @foreach ($join_chat_rooms->whereIn("distinction_number", [1, 4]) as $join_chat_room)
                                    @if ($join_chat_room->office_id == $office->id)
                                        <li>
                                            <a id="chat_room_{{ $join_chat_room->id }}" href="{{ route('chat.show', $join_chat_room->id) }}">
                                            @if ($join_chat_room->distinction_number == 4){{ $join_chat_room->room_title }} @else {{ $office->office_name }}職員 @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($join_chat_rooms->whereIn("distinction_number", [3, 4]) as $join_chat_room)
                                    @if ($join_chat_room->office_id == $office->id)
                                        <li>
                                            <a id="chat_room_{{ $join_chat_room->id }}" href="{{ route('chat.show', $join_chat_room->id) }}">
                                            @if ($join_chat_room->distinction_number == 4){{ $join_chat_room->room_title }} @else {{ $office->office_name }}職員 @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>