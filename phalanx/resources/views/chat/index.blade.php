@extends('chat_room.sidebar')

@section('css')
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection

@section('center')
    @if ($errors->any())
    <div class="alert alert-danger w-100">
        <span>入力に誤りがあります。</span>
    </div>
    @endif
    <div>
        <span id="room_title"></span>
    </div>

    <hr>

    @foreach ($chat_room->chat_texts as $chat_text)
    @php
        $created_at = new \Carbon\Carbon($chat_text->created_at);
    @endphp
        <div>
            <span class="text-danger"></span>　{{ $created_at->isoFormat('YYYY年MM月DD日(ddd) HH:mm') }}
        </div>
        <div class="white_space_pre_wrap ml-4">
            <p>{{ $chat_text->chat_text }}</p>
        </div>
    @endforeach

    <div class="position-fixed chat_bottom bg-white w-100">
        <div class="m-2">
            <form action="{{ route('chat.store', $chat_room->id) }}" method="post" class="form-row mx-auto">
                @csrf
                <div class="col-6">
                    <textarea id="chat_text" name="chat_text" class="form-control chat_textarea @error('chat_text') is-invalid @enderror" rows="1">{{ old('chat_text') }}</textarea>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" type="submit">送信</button>
                </div>
            </form>
            @error('chat_text')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script>
        $(function() {
            const id = 1;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/chat/' + id + '/getChatRoomJson',
                type:'GET',
            })
            .done(function(json){
                console.log(json);
                $('#room_title').text(json['room_title']);
            })
            .fail(function(json){
                alert('ajax失敗');
            });
        });
    </script>
@endsection
