@extends('chat.sidebar')

@section('css')
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection

@section('center')
    <div id="chat_header">
        <span id="room_name">
    </div>

    <div id="chat_log">
    </div>

    <div id="chat_footer">
        <div class="m-2">
            <div class="form-row mx-auto">
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
            getChatLog();
            // 10秒ごとに実行
            setInterval(() => {
                getChatLog();
            }, 10000);
            
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
                    url:'/chat/' + id + '/storeChatJson',
                    dataType: "json",
                    data: {
                        chat_text: chat_text,
                    },
                })
                // 成功時
                .then((json) => {
                    // 入力フォームを空に
                    $('#chat_text').val('');
                    // ルーム名表示
                    $('#room_name').text(json.room_title);
                    // チャットログを空に
                    $("#chat_log").empty();
                    // チャットログ表示
                    $.map(json.chat_texts, function (val, index) {
                        html = `
                        <div class="chat_individual">
                            <div class="chat_header">
                                <span class="text-danger">${val.user.name}</span>　${val.created_at}
                            </div>
                                
                            <div class="chat_text">${val.chat_text}</div>
                        </div>
                        `;
                        $("#chat_log").append(html);
                    });
                    // スクロール位置を元に戻す
                    $(window).scrollTop(scroll_top);
                })
                // 失敗時
                .fail((error) => {
                    alert('送信に失敗しました。');
                });
            });

            // チャット読み込み
            function getChatLog () {
                // スクロール位置を保存
                let scroll_top = $(window).scrollTop();
                console.log(scroll_top);
                // チャットログを空に
                $("#chat_log").empty();
                // Ajaxリクエスト
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                $.ajax({
                    url:'/chat/' + id + '/getChatLogJson',
                    type:'GET',
                })
                // 成功時
                .done(function(json){
                    console.log(json);
                    // ルーム名表示
                    $('#room_name').text(json.room_title);
                    // チャットログを空に
                    $("#chat_log").empty();
                    // チャットログ表示
                    $.map(json.chat_texts, function (val, index) {
                        html = `
                        <div class="chat_individual">
                            <div class="chat_header">
                                <span class="text-danger">${val.user.name}</span>　${val.created_at}
                            </div>
                                
                            <div class="chat_text">${val.chat_text}</div>
                        </div>
                        `;
                        $("#chat_log").append(html);
                    });
                    // スクロール位置を元に戻す
                    $(window).scrollTop(scroll_top);
                })
                // 失敗時
                .fail(function(json){
                    alert('受信に失敗しました。');
                });
            }
        });
    </script>
@endsection
