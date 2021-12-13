<div class="row">
    <h5 class="col-12 pt-3 font-weight-bold">参加者 ({{ $chat_room->users->count() }})</h5>
</div>
@foreach ($user_types as $user_type)
    <div class="row">
        @foreach ($offices as $office)
            @if ($user_type->id < 3 && $chat_room->users->where('user_type_id', $user_type->id)->where('office_id', $office->id)->count())
                <div>
                    <a data-toggle="collapse" @if($user_type->id === 1)href="#staff-{{ $office->id }}" @elseif ($user_type->id === 2) href="#user-{{ $office->id }}" @endif>
                        <h5 class="col-12 pt-3 text-dark font-weight-bold">{{ $office->office_name }}{{ $user_type->alias }} ({{ $chat_room->users->where('user_type_id', $user_type->id)->where('office_id', $office->id)->count() }})</h5>
                    </a>
                    <ul @if($user_type->id === 1)id="staff-{{ $office->id }}" @elseif ($user_type->id === 2) id="user-{{ $office->id }}" @endif class="col-12 pt-1 collapse show">
                        @foreach ($chat_room->users as $user)
                            @if ($user->user_type_id === $user_type->id && $user->office_id === $office->id)
                                <li class="@if ($user->id === Auth::user()->id) text-success @elseif($user->user_type_id === 1) text-danger @else text-success @endif">{{ $user->name }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
        @if ($user_type->id == 3 && $chat_room->users->where('user_type_id', 3)->where('office_id', $office->id)->count())
            <div>
                <a data-toggle="collapse" href="#trial">
                    <h5 class="col-12 pt-3 text-dark font-weight-bold">{{ $user_type->alias }} ({{ $chat_room->users->where('user_type_id', $user_type->id)->count() }})</h5>
                </a>
                <ul @if($user_type->id === 1)id="staff-{{ $office->id }}" @elseif ($user_type->id === 2) id="user-{{ $office->id }}" @else id="trial"@endif class="col-12 pt-1 collapse show">
                    @foreach ($chat_room->users as $user)
                        @if ($user->user_type_id === $user_type->id)
                            <li class="@if ($user->id === Auth::user()->id) text-success @elseif($user->user_type_id === 1) text-danger @else text-primary @endif">{{ $user->name }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endforeach