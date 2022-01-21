@if (Auth::user()->user_type_id == 1)
    <div class="p-3">
        <a href="{{ route('chat.index') }}" class="btn btn-primary btn-lg btn-block" role="button">通所者一覧</a>
    </div>
@endif
<div class="px-3">
    @if ($join_chat_rooms->where("distinction_number", 0)->isNotEmpty())
        <div class="pt-3">
            <h5>リテラル</h5>
            <ul class="pl-2 pt-1">
                <li>
                    <a class="chat_room_{{ $join_chat_rooms->where("distinction_number", 0)->first()->id }} room_title" href="{{ route("chat.show", $join_chat_rooms->where("distinction_number", 0)->first()->id) }}">
                        <span class="new d-none">●</span>全職員
                    </a>
                </li>
            </ul>
        </div>
    @endif
    @if ($join_chat_rooms->where("distinction_number", 4)->where("office_id", 0)->isNotEmpty())
        <div class="pt-3">
            <h5>その他</h5>
            <ul class="pl-2 pt-1">
                @foreach ($join_chat_rooms->where("distinction_number", 4)->where("office_id", 0) as $join_chat_room)
                    <li>
                        <a class="chat_room_{{ $join_chat_room->id }} room_title" href="{{ route('chat.show', $join_chat_room->id) }}">
                            <span class="new d-none">●</span>{{ $join_chat_room->room_title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @foreach ($offices as $office)
        @if ($office->id == Auth::user()->office_id)
            <div class="pt-3">
                <h5>{{ $office->office_name }}</h5>
                <ul class="pl-2 pt-1">
                    @if (Auth::user()->user_type_id === 1)
                        @foreach ($join_chat_rooms->whereIn("distinction_number", [1, 4]) as $join_chat_room)
                            @if ($join_chat_room->office_id == $office->id)
                                <li>
                                    <a class="chat_room_{{ $join_chat_room->id }} room_title" href="{{ route('chat.show', $join_chat_room->id) }}">
                                        <span class="new d-none">●</span>@if ($join_chat_room->distinction_number == 4){{ $join_chat_room->room_title }} @else {{ $office->office_name }}職員 @endif
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @else
                        @foreach ($join_chat_rooms->whereIn("distinction_number", [3, 4]) as $join_chat_room)
                            @if ($join_chat_room->office_id == $office->id)
                                <li>
                                    <a class="chat_room_{{ $join_chat_room->id }} room_title" href="{{ route('chat.show', $join_chat_room->id) }}">
                                        <span class="new d-none">●</span>@if ($join_chat_room->distinction_number == 4){{ $join_chat_room->room_title }} @else {{ $office->office_name }}職員 @endif
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
        @endif
    @endforeach
    <div class="btn_div">
        <button type="button" class="btn btn-block open_sub btn-outline-dark" data-toggle="collapse" data-target="#{{ $size }}SubOffices" aria-expanded="false" aria-controls="{{ $size }}SubOffices">
            <i class="fas fa-chevron-down"></i>
        </button>
    </div>
    <div class="collapse" id="{{ $size }}SubOffices">
        @foreach ($offices as $office)
            @if ($office->id != Auth::user()->office_id)
                <div class="pt-3">
                    <h5>{{ $office->office_name }}</h5>
                    <ul class="pl-2 pt-1">
                        @if (Auth::user()->user_type_id === 1)
                            @foreach ($join_chat_rooms->whereIn("distinction_number", [1, 4]) as $join_chat_room)
                                @if ($join_chat_room->office_id == $office->id)
                                    <li>
                                        <a class="chat_room_{{ $join_chat_room->id }} room_title" href="{{ route('chat.show', $join_chat_room->id) }}">
                                            <span class="new d-none">●</span>@if ($join_chat_room->distinction_number == 4){{ $join_chat_room->room_title }} @else {{ $office->office_name }}職員 @endif
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            @foreach ($join_chat_rooms->whereIn("distinction_number", [3, 4]) as $join_chat_room)
                                @if ($join_chat_room->office_id == $office->id)
                                    <li>
                                        <a class="chat_room_{{ $join_chat_room->id }} room_title" href="{{ route('chat.show', $join_chat_room->id) }}">
                                            <span class="new d-none">●</span>@if ($join_chat_room->distinction_number == 4){{ $join_chat_room->room_title }} @else {{ $office->office_name }}職員 @endif
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