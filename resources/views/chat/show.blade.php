@extends('chat.sidebar')

@section('css')
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection

@section('center')
    <div id="chat_main">
        <div id="chat_header">
            <span id="room_name">
        </div>

        <div id="chat_log">
        </div>

        <div id="chat_footer">
            <div class="m-2">
                <div class="form-row mx-auto">
                    <div class="col-7">
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
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
    <script>
        let id = @json($chat_room->id);
    </script>
    <script>
        $(function() {
            // $(window).on("scroll", function() {
            //     let currentPos = $(window).scrollTop();
            //     console.log(currentPos);
            // });
            // 初回チャット読み込み
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
                // ルーム名表示
                $('#room_name').text(json.room_title);
                // チャットログを空に
                $("#chat_log").empty();
                // チャットログ表示
                $.map(json.chat_texts, function (val, index) {
                    html = `
                    <div class="chat_individual">
                        <div class="chat_header">
                            <span class="text-danger">${val.user.name}</span>　${moment(val.created_at, "YYYY-MM-DD hh:mm:ss").locale('ja').format('llll')}
                        </div>
                            
                        <div class="chat_text">${val.chat_text}</div>
                    </div>
                    `;
                    $("#chat_log").append(html);
                    
                    // ブックマーク追加
                    if (val.id == json.newest_read_chat_text_id) {
                        html = `
                                <div id="bookmark">
                                    <span class="text-danger">-------------------------------bookmark-------------------------------------</span>
                                </div>
                                `;
                        $("#chat_log").append(html);
                    }
                });
                // bookmarkまでスクロール
                $("#center-scroll").scrollTop($('#bookmark').offset().top);
            })
            // 失敗時
            .fail(function(json){
                alert('受信に失敗しました。');
            });


            // 10秒ごとに最新チャット取得
            setInterval(() => {
                getNewChatLog();
            }, 10000);
            
            // 送信ボタンを押したらチャット送信
            $("#submit").on('click', function() {
                submitText();
            });

            // SHFIT+ENTERを押したらチャット送信
            $(window).keydown(function(e){
                if(event.shiftKey){
                    if(e.keyCode === 13){
                        submitText();
                        return false;
                    }
                }
            });

            
            function getNewChatLog() {
                // Ajaxリクエスト
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                $.ajax({
                    url:'/chat/' + id + '/getNewChatLogJson',
                    type:'GET',
                })
                // 成功時
                .done(function(json){
                    // ルーム名表示
                    $('#room_name').text(json.room_title);

                    // チャットログ表示
                    $.map(json.chat_texts, function (val, index) {
                        let beforeDate = moment(val.created_at, "YYYY-MM-DD hh:mm:ss");
                        var afterDate = beforeDate.format('YYYY年MM月DD日(ddd) HH:mm');
                        html = `
                        <div class="chat_individual">
                            <div class="chat_header">
                                <span class="text-danger">${val.user.name}</span>　${moment(val.created_at, "YYYY-MM-DD hh:mm:ss").locale('ja').format('llll')}
                            </div>
                                
                            <div class="chat_text">${val.chat_text}</div>
                        </div>
                        `;
                        $("#chat_log").append(html);
                    });
                })
                // 失敗時
                .fail(function(json){
                    alert('受信に失敗しました。');
                });
            }
            
            // チャット送信
            function submitText() {
                // 入力値を取得
                let chat_text = $('#chat_text').val();
                if (chat_text.length < 1) {
                    // 空ならなにもしない
                    return false;
                }
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
                    if (json.error) {// バリデーションエラー
                        alert(json.error);
                    } else {// 成功時
                        // 入力フォームを空に
                        $('#chat_text').val('');
                        getNewChatLog();
                    }
                })
                // 失敗時
                .fail((error) => {
                    alert('送信に失敗しました。');
                });
            }
        });
    </script>
@endsection
