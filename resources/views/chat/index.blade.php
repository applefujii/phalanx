@extends('chat_room.sidebar')

@section('css')
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection

@section('center')
    <div id="chat_header">
        <span id="room_name">
    </div>

    <div id="chat_texts">
    </div>

    <div id="chat_hooter">
        <div class="m-2">
            <div class="form-row mx-auto">
                @csrf
                <div class="col-6">
                    <textarea id="chat_text" name="chat_text" class="form-control chat_textarea @error('chat_text') is-invalid @enderror" rows="1" required="required">{{ old('chat_text') }}</textarea>
                    @error('chat_text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-auto">
                    <button id="submit" class="btn btn-primary">送信</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script>
        const id = @json($chat_room->id);
    </script>
    <script>
        $(function() {
            // Ajaxリクエスト
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url:'/chat/' + id + '/getChatRoomJson',
                type:'GET',
            })
            // 成功時
            .done(function(json){
                $('#room_name').text(json.room_title);
                $.map(json.chat_texts, function (val, index) {
                    html = `
                    <div class="chat_individual">
                        <div class="chat_header">
                            <span class="text-danger">${val.user.name}</span>　${val.created_at}
                        </div>
                            
                        <div class="chat_text">${val.chat_text}</div>
                    </div>
                    `;
                    $("#chat_texts").append(html);
                });
            })
            // 失敗時
            .fail(function(json){
                alert('受信に失敗しました。');
            });
            
            // チャット送信
            $("#submit").on('click', function() {
                // 入力値を取得
                const chat_text = $('#chat_text').val();
                if (chat_text.length < 1) {
                    alert('メッセージが空です。');
                    return false;
                }
                // スクロール位置を保存
                const scroll_top = $(window).scrollTop();
                // Ajaxリクエスト
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                $.ajax({
                    type: "post",
                    url:'/chat/' + id + '/storeJson',
                    dataType: "json",
                    data: {
                        chat_text: chat_text,
                    },
                })
                // 成功時
                .then((json) => {
                    $(window).scrollTop(scroll_top);
                    $('#chat_text').val('');
                    $('#room_name').text(json.room_title);
                    $("#chat_texts").empty();
                    $.map(json.chat_texts, function (val, index) {
                        html = `
                        <div class="chat_individual">
                            <div class="chat_header">
                                <span class="text-danger">${val.user.name}</span>　${val.created_at}
                            </div>
                                
                            <div class="chat_text">${val.chat_text}</div>
                        </div>
                        `;
                        $("#chat_texts").append(html);
                    });
                })
                // 失敗時
                .fail((error) => {
                    alert('送信に失敗しました。');
                });
            });
        });
    </script>
@endsection
