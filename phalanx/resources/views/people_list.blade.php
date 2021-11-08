<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="user">
            利用者
        </button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="staff">
            職員
        </button>

    
        <!-- Modal -->
        <div id="peopleListModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="peopleListModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="peopleListModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body d-flex flex-column insert-office">
                        {{-- jsで動的に追加 --}}
                        {{--
                        <div class="d-flex justify-content-center">
                            <p>─── <a data-toggle="collapse" href="#list-apple">アップル梅田</a> <input id="apple-all-check" class="all-check" type="checkbox" data-child-class=".apple"> ───</p>
                        </div>
                        <div id="list-apple" class="collapse show people_list">
                            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="apple" data-group="apple"> あああああ</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> いいいいい</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> ううううう</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> えええええ</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> おおおおお</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="apple" data-group="apple"> かかかかか</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> ききききき</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> くくくくく</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> けけけけけ</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> こここここ</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="apple" data-group="apple"> さささささ</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> ししししし</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> すすすすす</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> せせせせせ</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> そそそそそ</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="apple" data-group="apple"> たたたたた</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> ちちちちち</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> つつつつつ</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> ててててて</p>
                                    <p><input type="checkbox" class="apple" data-group="apple"> ととととと</p>
                                </div>
                            </div>
                        </div>
                
                        <div class="d-flex justify-content-center">
                            <p>─── <a data-toggle="collapse" href="#list-mint">ミント大阪</a> <input id="mint-all-check" class="all-check" type="checkbox" data-child-class=".mint"> ───</p>
                        </div>
                        <div id="list-mint" class="collapse people_list">
                            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="mint" data-group="mint"> あああああ</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> いいいいい</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> ううううう</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> えええええ</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> おおおおお</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="mint" data-group="mint"> かかかかか</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> ききききき</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> くくくくく</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> けけけけけ</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> こここここ</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="mint" data-group="mint"> さささささ</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> ししししし</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> すすすすす</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> せせせせせ</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> そそそそそ</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="mint" data-group="mint"> たたたたた</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> ちちちちち</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> つつつつつ</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> ててててて</p>
                                    <p><input type="checkbox" class="mint" data-group="mint"> ととととと</p>
                                </div>
                            </div>
                        </div>
                
                        <div class="d-flex justify-content-center">
                            <p>─── <a data-toggle="collapse" href="#list-maple">メープル関西</a> <input id="maple-all-check" class="all-check" type="checkbox" data-child-class=".maple"> ───</p>
                        </div>
                        <div id="list-maple" class="collapse people_list">
                            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="maple" data-group="maple"> あああああ</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> いいいいい</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> ううううう</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> えええええ</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> おおおおお</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="maple" data-group="maple"> かかかかか</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> ききききき</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> くくくくく</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> けけけけけ</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> こここここ</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="maple" data-group="maple"> さささささ</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> ししししし</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> すすすすす</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> せせせせせ</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> そそそそそ</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="maple" data-group="maple"> たたたたた</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> ちちちちち</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> つつつつつ</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> ててててて</p>
                                    <p><input type="checkbox" class="maple" data-group="maple"> ととととと</p>
                                </div>
                            </div>
                        </div>
                
                        <div class="d-flex justify-content-center">
                            <p>─── <a data-toggle="collapse" href="#list-experience">体験</a> <input id="experience-all-check" class="all-check" type="checkbox" data-child-class=".experience"> ───</p>
                        </div>
                        <div id="list-experience" class="collapse people_list">
                            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="experience" data-group="experience"> あああああ</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> いいいいい</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> ううううう</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> えええええ</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> おおおおお</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="experience" data-group="experience"> かかかかか</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> ききききき</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> くくくくく</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> けけけけけ</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> こここここ</p>
                                </div>
                                <div class="flex-fill ml-3">
                                    <p><input type="checkbox" class="experience" data-group="experience"> さささささ</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> ししししし</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> すすすすす</p>
                                    <p><input type="checkbox" class="experience" data-group="experience"> せせせせせ</p>
                                </div>
                            </div>
                        </div>
                        --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                        <button id="people-list-modal-ok" type="button" class="btn btn-primary">決定</button>
                    </div>
                </div>
            </div>
        </div>

    </body>


    {{-- jQuery読み込み --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        /*
        事務所
        ユーザー
        ユーザー 誰がチェックされているか
        事務所ごとの人数 職員と利用者それぞれ ←計算する
        */
        // 画面幅
        var viewportWidth = $(window).width();
        //カラム数
        var peopleColumn = viewportWidth<576 ? 2 : viewportWidth<768 ? 3 : viewportWidth<992 ? 4 : viewportWidth<1200 ? 5 : viewportWidth<1400 ? 6 : 7;
        var oldPeopleColumn = peopleColumn;
        //1カラムの人数
        var oneColumnNumber = Math.floor(11/peopleColumn) +1;   //※総人数取得 事業所ごと配列
        //チェックされている人のID
        var checkList = [];
        var office = [
            { id : 1, en_office_name : "apple", office_name : "アップル梅田" },
            { id : 2, en_office_name : "mint", office_name : "ミント大阪" },
            { id : 3, en_office_name : "maple", office_name : "メープル関西" },
            { id : 0, en_office_name : "experience", office_name : "体験" }
        ];
        var myOffice = "maple";
        var targetUserType;
        var people = [
            { id : 1, name : "梅田太郎", office_id : 2, user_type_id : 2 },
            { id : 2, name : "いいいいい", office_id : 2, user_type_id : 2  },
            { id : 3, name : "ううううう", office_id : 2, user_type_id : 2  },
            { id : 4, name : "えええええ", office_id : 2, user_type_id : 2  },
            { id : 5, name : "おおおおお", office_id : 2, user_type_id : 2  },
            { id : 6, name : "かかかかか", office_id : 2, user_type_id : 2  },
            { id : 7, name : "ききききき", office_id : 2, user_type_id : 2  },
            { id : 8, name : "くくくくく", office_id : 2, user_type_id : 2  },
            { id : 9, name : "けけけけけ", office_id : 2, user_type_id : 2  },
            { id : 10, name : "こここここ", office_id : 2, user_type_id : 2  },
            { id : 11, name : "さささささ", office_id : 2, user_type_id : 2  },
            { id : 12, name : "アップル職員1", office_id : 2, user_type_id : 1  },
            { id : 13, name : "アップル職員2", office_id : 2, user_type_id : 1  },
            
            { id : 14, name : "ミント二郎", office_id : 3, user_type_id : 2  },
            { id : 15, name : "いいいいい", office_id : 3, user_type_id : 2  },
            { id : 16, name : "ううううう", office_id : 3, user_type_id : 2  },
            { id : 17, name : "えええええ", office_id : 3, user_type_id : 2  },
            { id : 18, name : "おおおおお", office_id : 3, user_type_id : 2  },
            { id : 19, name : "かかかかか", office_id : 3, user_type_id : 2  },
            { id : 20, name : "ききききき", office_id : 3, user_type_id : 2  },
            { id : 21, name : "くくくくく", office_id : 3, user_type_id : 2  },
            { id : 22, name : "けけけけけ", office_id : 3, user_type_id : 2  },
            { id : 23, name : "こここここ", office_id : 3, user_type_id : 2  },
            { id : 24, name : "さささささ", office_id : 3, user_type_id : 2  },
            { id : 25, name : "ミント職員3", office_id : 3, user_type_id : 1  },
            { id : 26, name : "ミント職員4", office_id : 3, user_type_id : 1  },
            
            { id : 27, name : "メープル三郎", office_id : 4, user_type_id : 2  },
            { id : 28, name : "いいいいい", office_id : 4, user_type_id : 2  },
            { id : 29, name : "ううううう", office_id : 4, user_type_id : 2  },
            { id : 30, name : "えええええ", office_id : 4, user_type_id : 2  },
            { id : 31, name : "おおおおお", office_id : 4, user_type_id : 2  },
            { id : 32, name : "かかかかか", office_id : 4, user_type_id : 2  },
            { id : 33, name : "ききききき", office_id : 4, user_type_id : 2  },
            { id : 34, name : "くくくくく", office_id : 4, user_type_id : 2  },
            { id : 35, name : "けけけけけ", office_id : 4, user_type_id : 2  },
            { id : 36, name : "こここここ", office_id : 4, user_type_id : 2  },
            { id : 37, name : "さささささ", office_id : 4, user_type_id : 2  },
            { id : 38, name : "メープル職員5", office_id : 4, user_type_id : 1  },
            { id : 39, name : "メープル職員6", office_id : 4, user_type_id : 1  },
            
            { id : 40, name : "体験さん", office_id : 1, user_type_id : 2  },
            { id : 41, name : "いいいいい", office_id : 1, user_type_id : 2  },
            { id : 42, name : "ううううう", office_id : 1, user_type_id : 2  },
            { id : 43, name : "えええええ", office_id : 1, user_type_id : 2  },
            { id : 44, name : "おおおおお", office_id : 1, user_type_id : 2  },
            { id : 45, name : "かかかかか", office_id : 1, user_type_id : 2  },
            { id : 46, name : "ききききき", office_id : 1, user_type_id : 2  },
            { id : 47, name : "くくくくく", office_id : 1, user_type_id : 2  },
            { id : 48, name : "けけけけけ", office_id : 1, user_type_id : 2  },
            { id : 49, name : "こここここ", office_id : 1, user_type_id : 2  },
            { id : 50, name : "さささささ", office_id : 1, user_type_id : 2  },
        ];
        officeHtml = '\
            <div class="order-[OrderNo]">\n\
                <div class="d-flex justify-content-center">\n\
                    <p>─── <a data-toggle="collapse" href="#list-[EnName]" class="collapse-trigger"><i class="fas fa-chevron-down"></i> <b>[Name]</b></a> <input id="[EnName]-all-check" class="all-check" type="checkbox" data-child-class=".[EnName]"> ───</p>\n\
                </div>\n\
                <div id="list-[EnName]" class="collapse people_list">\n\
                    <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3 insert-[EnName]">\n\
                    </div>\n\
                </div>\n\
            </div>\n\
            ';

        peopleHtmlNest = '<div class="flex-fill ml-3">';
        peopleHtml = '<p><input type="checkbox" class="[EnName] check-individual" data-people-id="[PeopleId]" data-group="[EnName]"> [PeopleName]</p>';


        //-- 読み込まれたタイミングで実行
        $(function(){
            // ajaxの規定値を設定
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //-- APIからメンバー情報を取得
            $.ajax({
                type: "POST",
                url: "./api/v1.0/get/users.json", // 送り先
                data: {},   // 渡したいデータをオブジェクトで渡す
                dataType : "json",  // データ形式を指定
                scriptCharset: 'utf-8'  // 文字コードを指定
            })
            .done( function(param){     // paramに処理後のデータが入って戻ってくる
                    people = param; // 帰ってきたら実行する処理
                })
            .fail( function(XMLHttpRequest, textStatus, errorThrown){   // エラーが起きた時はこちらが実行される
                    console.log(XMLHttpRequest);    // エラー内容表示
            });

            //-- APIから事業所情報を取得
            $.ajax({
                type: "POST",
                url: "./api/v1.0/get/offices.json",
                data: {},
                dataType : "json",
                scriptCharset: 'utf-8'
            })
            .done( function(param){
                    office = param;
                    office.push({ id : 0, en_office_name : "experience", office_name : "体験" });
                })
            .fail( function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(XMLHttpRequest);
            });

            // ※APIのテスト
            $.ajax({
                type: "POST",
                url: "./api/v1.0/set/notifications.json", // 送り先
                data: {
                    records : [
                        { content : "複数登録1", start_at :"2022/01/01 00:00:00" , end_at : "2022/01/01 00:00:00", is_all_day : "0" },
                        { content : "複数登録2", start_at :"2022/01/01 00:00:00" , end_at : "2022/01/01 00:00:00", is_all_day : "1" },
                        { content : "複数登録3", start_at :"2022/01/01 00:00:00" , end_at : "2022/01/01 00:00:00", is_all_day : "0" }
                    ]
                 },   // 渡したいデータをオブジェクトで渡す
                dataType : "json",  // データ形式を指定
                scriptCharset: 'utf-8'  // 文字コードを指定
            })
            .done( function(param){     // paramに処理後のデータが入って戻ってくる
                console.log(param);
                })
            .fail( function(XMLHttpRequest, textStatus, errorThrown){   // エラーが起きた時はこちらが実行される
                    console.log(XMLHttpRequest);    // エラー内容表示
            });

            // $.ajax({
            //     type: "POST",
            //     url: "./api/v1.0/get/notifications.json", // 送り先
            //     data: {},   // 渡したいデータをオブジェクトで渡す
            //     dataType : "json",  // データ形式を指定
            //     scriptCharset: 'utf-8'  // 文字コードを指定
            // })
            // .done( function(param){     // paramに処理後のデータが入って戻ってくる
            //         console.log(param); // 帰ってきたら実行する処理
            //     })
            // .fail( function(XMLHttpRequest, textStatus, errorThrown){   // エラーが起きた時はこちらが実行される
            //         console.log(XMLHttpRequest);    // エラー内容表示
            // });

            //-- ※checkListにチェックされている人のIDを代入
            checkList.push(5);
        });


        //-- モーダルが呼び出されたとき
        $(document).ready(function(){
            $(document).on('show.bs.modal','#peopleListModal', function ( event ) {
                var button = $(event.relatedTarget) //モーダルを呼び出すときに使われたボタンを取得
                var targetGroup = button.data('target-group');

                //職員ボタンから
                if( targetGroup == "staff" ) {
                    targetUserType = 1;
                    $('#peopleListModalLabel').text('職員一覧');
                }
                //利用者ボタンから
                else if( targetGroup == "user" ) {
                    targetUserType = 2;
                    $('#peopleListModalLabel').text('利用者一覧');
                }

                modalWrite();
            });
        });

        //-- ウィンドウサイズが変更されたとき
        $(window).resize(function(){
            viewportWidth = $(window).width();
            // 横幅に応じてカラム数変更
            peopleColumn = viewportWidth<576 ? 2 : viewportWidth<768 ? 3 : viewportWidth<992 ? 4 : viewportWidth<1200 ? 5 : viewportWidth<1400 ? 6 : 7;
            if( peopleColumn != oldPeopleColumn ) { 
                oldPeopleColumn = peopleColumn;
                oneColumnNumber = Math.floor(11/peopleColumn) +1;
                if( ($('#peopleListModal').data('bs.modal') || {})._isShown ) {
                    modalWrite();
                }
            }
        });

        //-- 展開・縮小ボタンが押されたとき
        $(document).on('click', '.collapse-trigger', function(){
            let fas = $(this).find(".fas");
            if( fas.hasClass("fa-chevron-down") ) {
                fas.removeClass("fa-chevron-down");
                fas.addClass("fa-chevron-up");
            } else {
                fas.removeClass("fa-chevron-up");
                fas.addClass("fa-chevron-down");
            }
        });

        //-- 全てにチェックがクリックされたとき
        $(document).on('click', '.all-check', function(){
            if ( $(this).prop('checked') == true ) {
                $($(this).data('child-class')).each(function(index, element){
                    $(this).prop('checked', true);
                    if( checkList.includes($(this).data('people-id')) == false )
                        checkList.push($(this).data('people-id'));
                });
            } else {
                $($(this).data('child-class')).each(function(index, element){
                    $(this).prop('checked', false);
                    checkList.splice(checkList.indexOf($(this).data('people-id')), 1);
                });
            }
        });

        //-- 個別チェックに変更があった時(全チェック時には発火しないので個別対応)
        $(document).on('change', 'div.people_list input[type=checkbox]', function(){
            if( $(this).prop('checked') ) {
                //増加
                checkList.push($(this).data('people-id'));
            } else {
                //削減
                checkList.splice(checkList.indexOf($(this).data('people-id')), 1);
            }
        });

        //-- 個別チェックがクリックされたとき
        $(document).on('click', 'div.people_list input[type=checkbox]', function(){
            //-- 全チェックになった時と、その逆の動作
            let fAllCheck = true;
            $('.'+$(this).data('group')).each(function(index, element){
                if( element.checked == false ) fAllCheck = false;
            });
            $('#' + $(this).data('group') + '-all-check').prop('checked', fAllCheck);
        });

        //-- 決定ボタンを押したときの動作
        $('#people-list-modal-ok').on('click', function(){
            console.log(checkList);
        });


        function modalWrite() {
            let insertOffice = $('.insert-office');
            insertOffice.empty();
            $.each(office, function(index, element){
                //-- 各種置換
                let st = officeHtml.replace(/\[EnName\]/g, element.en_office_name);
                st = st.replace(/\[Name\]/g, element.office_name);
                // 自分の事務所を
                if( element.en_office_name == myOffice) {
                    // 表示順を最上に、初期状態を展開に
                    st = st.replace(/\[OrderNo\]/g, "0");
                    st = st.replace(/fa-chevron-down/g, "fa-chevron-up");
                    st = st.replace(/(?<=class="collapse people_list)(?=")/g, " show");
                }
                else st = st.replace(/\[OrderNo\]/g, index +1);

                insertOffice.append(st);

                let insertPeople = $('.insert-' + element.en_office_name);
                let count = 0, countAll = 0;
                let nest;
                let fAllCheck = true;
                let fNotClose = false;
                insertPeople.empty();
                $.each(people, function(index2, element2){
                    let cc = count % oneColumnNumber;
                    if(element2.office_id == element.id) {
                        //-- targetUserTypeに一致するものを表示させる
                        if( element2.user_type_id == targetUserType ) {
                            if(cc == 0) {
                                nest = $(peopleHtmlNest);
                                fNotClose = true;
                            }
                            let st2 = peopleHtml.replace(/\[EnName\]/g, element.en_office_name);
                            st2 = st2.replace(/\[PeopleId\]/g, element2.id);
                            st2 = st2.replace(/\[PeopleName\]/g, element2.name);
                            if( checkList.includes(element2.id) ) {
                                st2 = st2.replace(/(?<=<input type="checkbox".*?check-individual[^>]*)(?=>)/g, " checked");
                            } else {
                                fAllCheck = false;
                            }
                            nest.append(st2);

                            if(cc == oneColumnNumber -1) {
                                insertPeople.append(nest);
                                fNotClose = false;
                            }
                            count++;
                            countAll++;
                        }
                    }
                });

                if( fNotClose ) {
                    insertPeople.append(nest);
                    fNotClose = false;
                }

                // 1つ以上項目があって、全てにチェックが付いていたら全チェックをcheckedにする
                if( countAll > 0 )
                    $('#' + element.en_office_name + '-all-check').prop('checked', fAllCheck);
            });
        }

    </script>

</html>
