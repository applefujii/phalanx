$(() => {
    // チャットルーム名表示位置調整
    $("#chat_header").offset({
        top: $('nav').outerHeight()
    });

    // スクロール可能な部分の高さ
    $("#chat_scroll").innerHeight(
        $(window).height() - $('nav').outerHeight() - $('#chat_header').outerHeight() - $('#chat_footer').outerHeight()
    );

    // 最新チャットメッセージ取得中かどうか
    let is_getting_text = false;

    // 最新チャットメッセージ閲覧済みかどうか
    let is_checked_latest = false;

    // 表示している中で最も古いチャットテキストのID
    let oldest_display_chat_text_id = 1;

    // 新着ログ部分の高さ
    let new_height = 0;

    // 入力値の行数
    let rows = 1;

    // フッターのデフォルト高さ
    const footer_height_default = $('#chat_footer').outerHeight();

    // 入力部の１行の高さ
    const chat_text_line_height = $("#chat_text").css('line-height').replace(/[^0-9.]/g, '');

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
            if (room.user_id && auth_user_type_id !== 1) {
                room_title = chat_room_office_name + ' 職員';
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
            
            // サイドバーのルーム名の文字色変更
            $(`#chat_room[${chat_room_id}]`).removeClass('text-danger');

            // bookmarkがあれば
            if ($('#bookmark').length) {
                // bookmarkまでスクロール
                $("#chat_scroll").scrollTop($('#bookmark').offset().top - $('nav').outerHeight() - $('#chat_header').outerHeight());
            } else {
                // 末尾までスクロール
                $("#chat_scroll").scrollTop($("#chat_scroll").get(0).scrollHeight);
            }
        })
        .fail(() => {
            // 失敗時
            $('#error_message').text('メッセージの受信に失敗しました。');
            $('#error').show();
        });

    // ----------------------------10秒ごとに最新チャット取得----------------------------
    setInterval(() => {
        getNewChatLog();
    }, 10000);

    // ----------------------------チャット送信----------------------------
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

    // ----------------------------その他処理----------------------------
    
    // 画面サイズが変更されたら
    $(window).on('resize', () => {
        // スクロール可能な部分の高さ
        $("#chat_scroll").innerHeight(
            $(window).height() - $('nav').outerHeight() - $('#chat_header').outerHeight() - $('#chat_footer').outerHeight()
        );
        // 入力部の高さ変更
        changeHeights();
    });

    // 入力開始したら
    $("#chat_text").on('change keyup keydown paste cut', () => {
        // エラーメッセージ非表示
        $('#error').hide();
        changeHeights();
    });

    //スクロールしたら
    $("#chat_scroll").on("scroll", () => {
        // 一番下までスクロールしたら
        // ヘッダーの高さ＋フッターの高さ＋チャット表示部のスクロール長－スクロール量－ウィンドウ高さ
        if ($('nav').outerHeight() + $('#chat_header').outerHeight() + $('#chat_footer').outerHeight() + $("#chat_scroll").get(0).scrollHeight - $("#chat_scroll").scrollTop() - $(window).height() <= 10) {
            //新着ありメッセージ非表示
            $('#new').hide();
            // 最新チャットメッセージ閲覧済み
            is_checked_latest = true;
            new_height = 0;
        }

        // 一番上までスクロールしたら
        if ($("#chat_scroll").scrollTop() == 0) {
            // 過去ログ表示
            getOldChatLog();
        }
    });

    // 最下ボタンを押したら最下までスクロール
    $("#to_bottom_button").on('click', () => {
        $("#chat_scroll").animate({scrollTop: $("#chat_scroll").get(0).scrollHeight}, 500, 'swing');
    });

    // 新着ボタンを押したらbookmarkまでスクロール
    $("#new").on('click', () => {
        $("#chat_scroll").animate({scrollTop: $("#chat_scroll").get(0).scrollHeight - $('#bookmark').outerHeight() - new_height}, 500, 'swing');
    });

    // ----------------------------関数----------------------------
    // 新着メッセージ取得
    function getNewChatLog() {
        // 既に取得中なら新たに取得しない
        if (!is_getting_text) {
            return false;
        }
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
                    let is_scroll_bottom = $('nav').outerHeight() + $('#chat_header').outerHeight() + $('#chat_footer').outerHeight() + $("#chat_scroll").get(0).scrollHeight - $("#chat_scroll").scrollTop() - $(window).height() <= 10;

                    $.map(room.chat_texts, (val, index) => {
                        // チャット履歴表示
                        $("#chat_log").append(formChatText(val, index));

                        // 自分の書き込みなら
                        if (val.user_id == auth_user_id) {
                            my_text = true;
                        }
                    });
                    
                    
                    // 新着ログ部分の高さの差分
                    let difference = $('#chat_log').innerHeight() - old_height;
                    new_height += difference;

                    // 自分の書き込みがあるか最下までスクロールしていた場合
                    if (my_text || is_scroll_bottom) {
                        // 末尾までスクロール
                        $("#chat_scroll").animate({scrollTop: $("#chat_scroll").get(0).scrollHeight}, 500, 'swing');
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

    // 過去メッセージ取得
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

    // チャット送信
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
                    // フッター等の高さ調整
                    changeHeights();
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

    // チャット履歴表示
    function formChatText(val, index) {
        // ユーザー名のCSS
        let name_css = '';
        // 自分の書き込みなら
        if (val.user_id == auth_user_id) {
            name_css = 'text-success font-weight-bold';
            // 職員の書き込みなら
        } else if (val.user.user_type_id == 1) {
            name_css = 'text-danger font-weight-bold';
            // それ以外
        } else {
            name_css = 'text-primary font-weight-bold';
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

    // ブックマーク表示
    function displayBookmark() {
        let html = `
                <div id="bookmark" class="bg-success text-center">
                    <span class="text-light">新着</span>
                </div>
                `;
        $("#chat_log").append(html);
    }

    // フッター等の高さ調整
    function changeHeights() {
        // 入力値の行数
        let new_rows = $("#chat_text").val().split('\n').length;
        
        if (new_rows > maxRows()) {
            new_rows = maxRows();
        }

        // 変化した行数
        let rows_difference = new_rows - rows;
        // 行数に変化があれば
        if (rows_difference !== 0) {
            // スクロール量
            let scrollTop = $("#chat_scroll").scrollTop();
            // 最下までスクロールしているか
            let is_scroll_bottom = $('nav').outerHeight() + $('#chat_header').outerHeight() + $('#chat_footer').outerHeight() + $("#chat_scroll").get(0).scrollHeight - scrollTop - $(window).height() <= 10;
            
            // 変化した高さ
            let height_difference = chat_text_line_height * rows_difference;

            // 現在のフッター等の高さ
            let chat_text_height = $('#chat_text').innerHeight();
            let chat_footer_height = $('#chat_footer').innerHeight();
            let to_bottom_bottom = $("#to_bottom").css('bottom');
        
            // 行数に応じてフッター等の高さ調整
            $('#chat_text').innerHeight(chat_text_height + height_difference);
            $('#chat_footer').innerHeight(chat_footer_height + height_difference);
            $("#to_bottom").css({bottom: to_bottom_bottom + height_difference});
            $("#new").css({bottom: to_bottom_bottom + height_difference});
            $("#error").css({bottom: to_bottom_bottom + height_difference});
            $("#chat_scroll").innerHeight(
                $(window).height() - $('nav').outerHeight() - $('#chat_header').outerHeight() - $('#chat_footer').outerHeight()
            );

            // 一番下までスクロールしていたら
            if (is_scroll_bottom) {
                // スクロール位置修正
                $("#chat_scroll").scrollTop(scrollTop + height_difference);
            }
            // 現在の行数を保存
            rows = new_rows;
        }
    }

    // フッターの最大行数
    function maxRows() {
        let maxRows = 1;
        while ($(window).height()/2 > footer_height_default + $("#chat_text").css('line-height').replace(/[^0-9.]/g, '') * (maxRows -1)) {
            maxRows++;
        }
        return maxRows;
    }
});