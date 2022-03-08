<h5 class="px-3 pt-3 font-weight-bold">参加者 ({{ $chat_room->users->count() }})</h5>
@foreach ($user_types as $user_type)
    <div class="px-3">
        @foreach ($offices as $office)
            @if ($user_type->id < 3 && $chat_room->users->where('user_type_id', $user_type->id)->where('office_id', $office->id)->count())
                <a data-toggle="collapse" class="no-close" @if($user_type->id === 1)href="#{{ $size }}-staff-{{ $office->id }}" @elseif ($user_type->id === 2) href="#{{ $size }}-user-{{ $office->id }}" @endif>
                    <h5 class="pt-3 text-dark font-weight-bold">{{ $office->office_name }}{{ $user_type->alias }} ({{ $chat_room->users->where('user_type_id', $user_type->id)->where('office_id', $office->id)->count() }})</h5>
                </a>
                <ul @if($user_type->id === 1)id="{{ $size }}-staff-{{ $office->id }}" @elseif ($user_type->id === 2) id="{{ $size }}-user-{{ $office->id }}" @endif class="mb-0 pl-2 collapse show">
                    @foreach ($chat_room->users as $user)
                        @if ($user->user_type_id === $user_type->id && $user->office_id === $office->id)
                            <li class="py-1 @if ($user->id === Auth::user()->id) text-success @elseif($user->user_type_id === 1) text-danger @else text-primary @endif">{{ $user->name }}</li>
                        @endif
                    @endforeach
                </ul>
            @endif
        @endforeach
        @if ($user_type->id == 3 && $chat_room->users->where('user_type_id', 3)->count())
            <a data-toggle="collapse" href="#{{ $size }}-trial">
                <h5 class="pt-3 text-dark font-weight-bold">{{ $user_type->alias }} ({{ $chat_room->users->where('user_type_id', $user_type->id)->count() }})</h5>
            </a>
            <ul id="{{ $size }}-trial" class="pl-2 mb-0 collapse show">
                @foreach ($chat_room->users as $user)
                    @if ($user->user_type_id === $user_type->id)
                        <li class="py-1 @if ($user->id === Auth::user()->id) text-success @else text-primary @endif">{{ $user->name }}</li>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
@endforeach