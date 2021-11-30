$(() => {
    // スクロール可能な部分の高さ
    const fixed_height = $('nav').innerHeight() + $('#chat_header').innerHeight() + $('#chat_footer').innerHeight();
    $("#chat_scroll").css("height", `calc(100vh - 2px - ${fixed_height}px)`);

    // 最新チャットメッセージ取得中かどうか
    let is_getting_text = false;

    // 最新チャットメッセージ閲覧済みかどうか
    let is_checked_latest = false;

    // 表示している中で最も古いチャットテキストのID
    let oldest_display_chat_text_id = 1;

    // 新着ありメッセージ非表示
    $('#new').hide();

    //スクロールしたら
    $("#chat_scroll").on("scroll", () => {
        
        //ウィンドウの一番下までスクロールしたら
        // ヘッダーの高さ＋チャット表示部のスクロール長－スクロール量－ウィンドウ高さ
        if ($('nav').innerHeight() + $("#chat_scroll").get(0).scrollHeight - $("#chat_scroll").scrollTop() - $(window).innerHeight() <= 10) {
            //新着ありメッセージ非表示
            $('#new').hide();
            // 最新チャットメッセージ閲覧済み
            is_checked_latest = true;
        }

        // 一番上までスクロールしたら
        if ($("#chat_scroll").scrollTop() == 0) {
            // 過去ログ表示
            getOldChatLog();
        }
    });

    // エラーメッセージ非表示
    $('#error').hide();

    // 入力開始したらエラーメッセージ非表示
    $("#chat_text").on('keydown', () => {
        $('#error').hide();
    });

    // 最下ボタンを押したら最下に移動
    $("#to_bottom_button").on('click', () => {
        $("#chat_scroll").scrollTop($("#chat_scroll").get(0).scrollHeight);
    });

    // ----------------------------初回チャット読み込み----------------------------
    // Ajaxリクエスト
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: '/chat/' + chat_room_id + '/getChatLogJson',
        type: 'GET',
    })
        .done((room) => {
            // 成功時
            // ルーム名
            let room_title = "";
            // 個人用ルームかつログイン者が職員でないとき
            if (room.user_id && user.user_type_id !== 1) {
                room_title = user.office.office_name + ' 職員';
            } else {
                room_title = room.room_title;
            }
            // ヘッダーにルーム名表示
            $('#room_name').text(room_title);
            // メッセージ入力のプレースホルダーにルーム名表示
            $('#chat_text').prop('placeholder', room_title + 'にメッセージ送信');

            // チャットログを空に
            $("#chat_log").empty();
            
            $.map(room.chat_texts.reverse(), (val, index) => {
                // チャット履歴表示
                $("#chat_log").append(formChatText(val, index));

                // ブックマーク追加
                if (val.id == room.newest_read_chat_text_id) {
                    displayBookmark();
                }
            });

            // もっとも古いチャットテキストのID更新
            oldest_display_chat_text_id = room.oldest_display_chat_text_id;

            // bookmarkがあれば
            if ($('#bookmark').length) {
                // bookmarkまでスクロール
                $("#chat_scroll").scrollTop($('#bookmark').offset().top - $('#bookmark').outerHeight(true) - $('#chat_header').innerHeight());
            }
        })
        .fail(() => {
            // 失敗時
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
        if (!$('#submit').prop('disabled') && event.shiftKey && event.key === 'Enter') {
            submitText();
            return false;
        }
    });

    // ----------------------------新着メッセージ取得----------------------------
    function getNewChatLog() {
        // 新着メッセージ取得中ならtrue
        is_getting_text = true;

        // 過去ログ部分の高さ
        let old_height = $('#chat_log').innerHeight();

        // Ajaxリクエスト
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: '/chat/' + chat_room_id + '/getNewChatLogJson',
            type: 'GET',
        })
            .done((room) => {
                // 成功時
                // 新着メッセージがある場合
                if (room.chat_texts.length > 0) {
                    // 最新メッセージを閲覧していたら
                    if (is_checked_latest) {
                        // ブックマーク削除
                        $("#bookmark").remove();
                        // ブックマーク追加
                        displayBookmark();
                    }

                    // 自分の書き込みがあるかの判定
                    let my_text = false;

                    // 新着メッセージ取得時に最下までスクロールしていたかどうかの判定
                    let is_scroll_bottom = $('nav').innerHeight() + $("#chat_scroll").get(0).scrollHeight - $("#chat_scroll").scrollTop() - $(window).innerHeight() <= 10;

                    $.map(room.chat_texts, (val, index) => {
                        // チャット履歴表示
                        $("#chat_log").append(formChatText(val, index));

                        // 自分の書き込みなら
                        if (val.user_id == user.id) {
                            my_text = true;
                        }
                    });

                    // 自分の書き込みがあるか最下までスクロールしていた場合
                    if (my_text || is_scroll_bottom) {
                        // 末尾までスクロール
                        $("#chat_scroll").scrollTop($("#chat_scroll").get(0).scrollHeight);
                    } else {
                        // 新着ありメッセージ表示
                        $('#new').show();
                    }

                    // 最新メッセージ閲覧未
                    is_checked_latest = false;
                }
            })
            .fail(() => {
                // 失敗時
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
            url: '/chat/' + chat_room_id + '/' + oldest_display_chat_text_id + '/getOldChatLogJson',
            type: 'GET',
        })
            .done((room) => {
                // 成功時
                // 新着メッセージがある場合
                if (room.chat_texts.length > 0) {
                    $.map(room.chat_texts, (val, index) => {
                        // チャット履歴表示
                        $("#chat_log").prepend(formChatText(val, index));

                        // 最古チャットテキストID更新
                        oldest_display_chat_text_id = val.id;
                    });

                    // 過去ログ部分の高さの差分
                    let difference = $('#chat_log').innerHeight() - old_height;

                    // スクロールを戻す
                    $("#chat_scroll").scrollTop(difference);
                }
            })
            // 失敗時
            .fail(() => {
                $('#error_message').text('メッセージの受信に失敗しました。');
                $('#error').show();
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
            url: '/chat/' + chat_room_id + '/storeChatJson',
            dataType: "json",
            data: {
                chat_text: chat_text,
            },
        })
            // 成功時
            .then((json) => {
                if (json.error) { // バリデーションエラー
                    $('#error_message').text(json.error);
                    $('#error').show();
                } else { // 成功時
                    // 入力フォームを空に
                    $('#chat_text').val('');
                    //最新チャット取得
                    getNewChatLog();
                }
            })
            // 失敗時
            .fail(() => {
                $('#error_message').text('送信に失敗しました。');
                $('#error').show();
            })
            .always(() => {
                // 送信ボタン有効化
                $('#submit').prop('disabled', false);
            });
    }


    // ----------------------------チャット履歴表示----------------------------
    function formChatText(val, index) {
        // ユーザー名のCSS
        let name_css = '';
        // 自分の書き込みなら
        if (val.user_id == user.id) {
            name_css = 'text-primary font-weight-bold';
            // 職員の書き込みなら
        } else if (val.user.user_type_id == 1) {
            name_css = 'text-danger font-weight-bold';
            // それ以外
        } else {
            name_css = 'text-success font-weight-bold';
        }
        return `
            <div class="chat_individual">
                <div class="chat_header">
                    <span class="${name_css}">${val.user.name}</span>　${moment(val.created_at, "YYYY-MM-DD hh:mm:ss").locale('ja').format('llll')}
                </div>
                    
                <div class="chat_text">${val.chat_text}</div>
            </div>
        `;
    }

    // ----------------------------ブックマーク表示----------------------------
    function displayBookmark() {
        let html = `
                <div id="bookmark" class="border border-success text-center">
                    <span class="text-success">新着</span>
                </div>
                `;
        $("#chat_log").append(html);
    }
});