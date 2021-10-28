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
            { Id : 2, EnName : "apple", Name : "アップル梅田" },
            { Id : 3, EnName : "mint", Name : "ミント大阪" },
            { Id : 4, EnName : "maple", Name : "メープル関西" },
            { Id : 1, EnName : "experience", Name : "体験" }
        ];
        var myOffice = "maple";
        var targetUserType;
        var people = [
            { Id : 1, Name : "梅田太郎", officeId : 2, user_type_id : 2 },
            { Id : 2, Name : "いいいいい", officeId : 2, user_type_id : 2  },
            { Id : 3, Name : "ううううう", officeId : 2, user_type_id : 2  },
            { Id : 4, Name : "えええええ", officeId : 2, user_type_id : 2  },
            { Id : 5, Name : "おおおおお", officeId : 2, user_type_id : 2  },
            { Id : 6, Name : "かかかかか", officeId : 2, user_type_id : 2  },
            { Id : 7, Name : "ききききき", officeId : 2, user_type_id : 2  },
            { Id : 8, Name : "くくくくく", officeId : 2, user_type_id : 2  },
            { Id : 9, Name : "けけけけけ", officeId : 2, user_type_id : 2  },
            { Id : 10, Name : "こここここ", officeId : 2, user_type_id : 2  },
            { Id : 11, Name : "さささささ", officeId : 2, user_type_id : 2  },
            { Id : 12, Name : "アップル職員1", officeId : 2, user_type_id : 1  },
            { Id : 13, Name : "アップル職員2", officeId : 2, user_type_id : 1  },
            
            { Id : 14, Name : "ミント二郎", officeId : 3, user_type_id : 2  },
            { Id : 15, Name : "いいいいい", officeId : 3, user_type_id : 2  },
            { Id : 16, Name : "ううううう", officeId : 3, user_type_id : 2  },
            { Id : 17, Name : "えええええ", officeId : 3, user_type_id : 2  },
            { Id : 18, Name : "おおおおお", officeId : 3, user_type_id : 2  },
            { Id : 19, Name : "かかかかか", officeId : 3, user_type_id : 2  },
            { Id : 20, Name : "ききききき", officeId : 3, user_type_id : 2  },
            { Id : 21, Name : "くくくくく", officeId : 3, user_type_id : 2  },
            { Id : 22, Name : "けけけけけ", officeId : 3, user_type_id : 2  },
            { Id : 23, Name : "こここここ", officeId : 3, user_type_id : 2  },
            { Id : 24, Name : "さささささ", officeId : 3, user_type_id : 2  },
            { Id : 25, Name : "ミント職員3", officeId : 3, user_type_id : 1  },
            { Id : 26, Name : "ミント職員4", officeId : 3, user_type_id : 1  },
            
            { Id : 27, Name : "メープル三郎", officeId : 4, user_type_id : 2  },
            { Id : 28, Name : "いいいいい", officeId : 4, user_type_id : 2  },
            { Id : 29, Name : "ううううう", officeId : 4, user_type_id : 2  },
            { Id : 30, Name : "えええええ", officeId : 4, user_type_id : 2  },
            { Id : 31, Name : "おおおおお", officeId : 4, user_type_id : 2  },
            { Id : 32, Name : "かかかかか", officeId : 4, user_type_id : 2  },
            { Id : 33, Name : "ききききき", officeId : 4, user_type_id : 2  },
            { Id : 34, Name : "くくくくく", officeId : 4, user_type_id : 2  },
            { Id : 35, Name : "けけけけけ", officeId : 4, user_type_id : 2  },
            { Id : 36, Name : "こここここ", officeId : 4, user_type_id : 2  },
            { Id : 37, Name : "さささささ", officeId : 4, user_type_id : 2  },
            { Id : 38, Name : "メープル職員5", officeId : 4, user_type_id : 1  },
            { Id : 39, Name : "メープル職員6", officeId : 4, user_type_id : 1  },
            
            { Id : 40, Name : "体験さん", officeId : 1, user_type_id : 2  },
            { Id : 41, Name : "いいいいい", officeId : 1, user_type_id : 2  },
            { Id : 42, Name : "ううううう", officeId : 1, user_type_id : 2  },
            { Id : 43, Name : "えええええ", officeId : 1, user_type_id : 2  },
            { Id : 44, Name : "おおおおお", officeId : 1, user_type_id : 2  },
            { Id : 45, Name : "かかかかか", officeId : 1, user_type_id : 2  },
            { Id : 46, Name : "ききききき", officeId : 1, user_type_id : 2  },
            { Id : 47, Name : "くくくくく", officeId : 1, user_type_id : 2  },
            { Id : 48, Name : "けけけけけ", officeId : 1, user_type_id : 2  },
            { Id : 49, Name : "こここここ", officeId : 1, user_type_id : 2  },
            { Id : 50, Name : "さささささ", officeId : 1, user_type_id : 2  },
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


        //読み込まれたタイミングで実行
        $(function(){
            //-- ※APIからメンバー情報を取得

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
                let st = officeHtml.replace(/\[EnName\]/g, element.EnName);
                st = st.replace(/\[Name\]/g, element.Name);
                // 自分の事務所を
                if( element.EnName == myOffice) {
                    // 表示順を最上に、初期状態を展開に
                    st = st.replace(/\[OrderNo\]/g, "0");
                    st = st.replace(/fa-chevron-down/g, "fa-chevron-up");
                    st = st.replace(/(?<=class="collapse people_list)(?=")/g, " show");
                }
                else st = st.replace(/\[OrderNo\]/g, index +1);

                insertOffice.append(st);

                let insertPeople = $('.insert-' + element.EnName);
                let count = 0, countAll = 0;
                let nest;
                let fAllCheck = true;
                let fNotClose = false;
                insertPeople.empty();
                $.each(people, function(index2, element2){
                    let cc = count % oneColumnNumber;
                    if(element2.officeId == element.Id) {
                        //-- targetUserTypeに一致するものを表示させる
                        if( element2.user_type_id == targetUserType ) {
                            if(cc == 0) {
                                nest = $(peopleHtmlNest);
                                fNotClose = true;
                            }
                            let st2 = peopleHtml.replace(/\[EnName\]/g, element.EnName);
                            st2 = st2.replace(/\[PeopleId\]/g, element2.Id);
                            st2 = st2.replace(/\[PeopleName\]/g, element2.Name);
                            if( checkList.includes(element2.Id) ) {
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
                    $('#' + element.EnName + '-all-check').prop('checked', fAllCheck);
            });
        }

    </script>

</html>
