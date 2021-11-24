$(function() {
    // ----------------------------グローバルスコープ----------------------------

    // 最新チャットメッセージ取得中かどうか
    let is_getting_text = false;

    // 最新チャットメッセージ閲覧済みかどうか
    let is_checked_latest = false;

    // 表示している中で最も古いチャットテキストのID
    let oldest_display_chat_text_id = 1;

    // ----------------------------メッセージ表示----------------------------

    // 新着ありメッセージ非表示
    $('#new').hide();
    
    //スクロールしたら
    $("#center-scroll").on("scroll", function() {
        // ドキュメントの高さ
        let document_height = $(document).innerHeight();
        // 最下位置
        let bottom_height = $('#bottom').offset().top;
        // スクロール量
        let scroll_top = $("#center-scroll").scrollTop();

        // 最下付近までスクロールしたら
        if (bottom_height - document_height < 10) {
            //新着ありメッセージ非表示
            $('#new').hide();
            // 最新チャットメッセージ閲覧済み
            is_checked_latest = true;
        }

        // 一番上までスクロールしたら
        if (scroll_top == 0) {
            // 過去ログ表示
            getOldChatLog();
        }
    });

    // エラーメッセージ非表示
    $('#error').hide();
    
    // 入力開始したらエラーメッセージ非表示
    $("#chat_text").on('keydown', function() {
        $('#error').hide();
    });

    // ----------------------------初回チャット読み込み----------------------------
    // Ajaxリクエスト
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url:'/chat/' + chat_room_id + '/getChatLogJson',
        type:'GET',
    })
    // 成功時
    .done((room) => {
        // ルーム名表示
        // 個人用ルームかつログイン者が職員でないとき
        if (room.user_id && user.user_type_id !== 1) {
            $('#room_name').text(user.office.office_name + ' 職員');
        } else {
            $('#room_name').text(room.room_title);
        }
        // チャットログを空に
        $("#chat_log").empty();
        // チャットログ表示
        $.map(room.chat_texts.reverse(), function (val, index) {// 逆順
            displayChatText (val, index);
            
            // ブックマーク追加
            if (val.id == room.newest_read_chat_text_id) {
                displayBookmark();
            }
        });
        // もっとも古いチャットテキストのID更新
        oldest_display_chat_text_id = room.oldest_display_chat_text_id;
        // bookmarkがあれば
        if($('#bookmark').length){
            // bookmarkまでスクロール
            $("#center-scroll").scrollTop($('#bookmark').offset().top);
        }
    })
    // 失敗時
    .fail((json) => {
        $('#error_message').text('メッセージの受信に失敗しました。');
        $('#error').show();
    });

    // ----------------------------10秒ごとに最新チャット取得----------------------------
    setInterval(() => {
        // 最新チャット取得中でないとき
        if (!is_getting_text) {
            getNewChatLog();
        }
    }, 10000);

    // 送信ボタンを押したらチャット送信
    $("#submit").on('click', () => {
            submitText();
        });

    // SHFIT+ENTERを押したらチャット送信
    // 連打防止で送信ボタン無効なら送信しない
    $(window).on('keydown', (event) => {
        if (!$('#submit').prop('disabled')) {
            if (event.shiftKey) {
                if (event.key === 'Enter') {
                    submitText();
                    return false;
                }
            }
        }
        });

    // ----------------------------新着メッセージ取得----------------------------
    function getNewChatLog() {
        // 新着メッセージ取得中ならtrue
        is_getting_text = true;

        // Ajaxリクエスト
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url:'/chat/' + chat_room_id + '/getNewChatLogJson',
            type:'GET',
        })
        // 成功時
        .done((json) => {
            // 新着メッセージがある場合
            if (json.chat_texts.length > 0) {
                // ドキュメントの高さ
                let document_height = $(document).innerHeight();
                // 最下位置
                let bottom_height = $('#bottom').offset().top;
                
                // 最新メッセージを閲覧していたら
                if (is_checked_latest) {
                    // ブックマーク削除
                    $("#bookmark").remove();
                    // ブックマーク追加
                    displayBookmark();
                }

                // チャットログ表示
                $.map(json.chat_texts, (val, index) => {
                        displayChatText(val, index);
                    });
                // 新着ありメッセージ表示
                $('#new').show();
                // 最新メッセージ閲覧未
                is_checked_latest = false;
            }
        })
        // 失敗時
        .fail((json) => {
            $('#error_message').text('メッセージの受信に失敗しました。');
            $('#error').show();
        })
        .always(() => {
            // 新着メッセージ取得完了
            is_getting_text = false;
        });
    }

    // ----------------------------過去メッセージ取得----------------------------
    function getOldChatLog() {
        // 過去ログ部分の高さ
        let old_height = $('#chat_log').innerHeight();
        
        // Ajaxリクエスト
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url:'/chat/' + chat_room_id + '/' + oldest_display_chat_text_id + '/getOldChatLogJson',
            type:'GET',
        })
        // 成功時
        .done((json) => {
            // 新着メッセージがある場合
            if (json.chat_texts.length > 0) {

                // チャットログ表示
                $.map(json.chat_texts, function (val, index) {
                    // ユーザー名のCSS
                    let name_css = 'text-danger font-weight-bold';
                    // 自分の書き込みなら
                    if (val.user_id == user.id) {
                        name_css = 'text-primary font-weight-bold';
                    }
                    let html = `
                    <div class="chat_individual">
                        <div class="chat_header">
                            <span class="${name_css}">${val.user.name}</span>　${moment(val.created_at, "YYYY-MM-DD hh:mm:ss").locale('ja').format('llll')}
                        </div>
                            
                        <div class="chat_text">${val.chat_text}</div>
                    </div>
                    `;
                    $("#chat_log").prepend(html);

                    // 最古チャットテキストID更新
                    oldest_display_chat_text_id = val.id;
                });
            }
        })
        // 失敗時
        .fail((json) => {
            $('#error_message').text('メッセージの受信に失敗しました。');
            $('#error').show();
        })
        .always(() => {
            // 過去ログ部分の高さ
            let new_height = $('#chat_log').innerHeight();
            // スクロールを戻す
            $("#center-scroll").scrollTop(new_height - old_height);
        });
    }
    
    // ----------------------------チャット送信----------------------------
    function submitText() {
        // 入力値を取得
        let chat_text = $('#chat_text').val();
        if (chat_text.length < 1) {
            // 空ならなにもしない
            return false;
        }
        // 送信ボタン無効化
        $('#submit').prop('disabled', true);

        // Ajaxリクエスト
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "post",
            url:'/chat/' + chat_room_id + '/storeChatJson',
            dataType: "json",
            data: {
                chat_text: chat_text,
            },
        })
        // 成功時
        .then((json) => {
            if (json.error) {// バリデーションエラー
                $('#error_message').text(json.error);
                $('#error').show();
            } else {// 成功時
                // 入力フォームを空に
                $('#chat_text').val('');
                //最新チャット取得
                getNewChatLog();
            }
        })
        // 失敗時
        .fail((json) => {
            $('#error_message').text('送信に失敗しました。');
            $('#error').show();
        })
        .always(() => {
            // 送信ボタン有効化
            $('#submit').prop('disabled', false);
        });
    }

    
    // ----------------------------チャット履歴表示----------------------------
    function displayChatText(val, index) {
        // ユーザー名のCSS
        let name_css = 'text-danger font-weight-bold';
        // 自分の書き込みなら
        if (val.user_id == user.id) {
            name_css = 'text-primary font-weight-bold';
        }
        let html = `
        <div class="chat_individual">
            <div class="chat_header">
                <span class="${name_css}">${val.user.name}</span>　${moment(val.created_at, "YYYY-MM-DD hh:mm:ss").locale('ja').format('llll')}
            </div>
                
            <div class="chat_text">${val.chat_text}</div>
        </div>
        `;
        $("#chat_log").append(html);
    }

    // ----------------------------ブックマーク表示----------------------------
    function displayBookmark() {
        let html = `
                <div id="bookmark" class="border border-primary text-center">
                    <span class="text-primary">新着</span>
                </div>
                `;
        $("#chat_log").append(html);
    }
});