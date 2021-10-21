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

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCentered">
            Launch centered demo modal
        </button>
    
        <!-- Modal -->
        <div class="modal" id="peopleList" tabindex="-1" role="dialog" aria-labelledby="peopleListLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="peopleListLabel">通所者一覧</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                        <button type="button" class="btn btn-primary">決定</button>
                    </div>
                </div>
            </div>
        </div>

    </body>


    {{-- jQuery読み込み --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        //チェックされている人のID
        var checkList = [];


        //-- モーダルが呼び出されたとき
        $('#peopleList').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) //モーダルを呼び出すときに使われたボタンを取得
            var targetGroup = button.data('target-group');
        }

        //-- ※phpで読み込んでおいた事務所とメンバーを画面幅に応じて挿入
        /*
        画面サイズに応じてカラム数を調節する。
        画面大：4カラム  画面中：3カラム  画面小：2カラム
        例：4カラムで19人 →5,5,5,4    4カラムで18人 →5,5,4,4    4カラムで17人 →5,4,4,4

        カラム例：
        <div class="d-flex justify-content-center">
            <p>─── <a data-toggle="collapse" href="#list-apple">アップル梅田</a> <input id="apple-all-check" class="all-check" type="checkbox" data-child-class=".apple"> ───</p>
            </div>
            <div id="list-apple" class="collapse people_list">
                <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                    <div class="flex-fill ml-3">
                    <p><input type="checkbox" class="apple" data-group="apple"> 名前A</p>
                    <p><input type="checkbox" class="apple" data-group="apple"> 名前B</p>
                </div>
            </div>
        </div>
        */

        //-- 全てにチェックがクリックされたとき
        $('.all-check').on('click', function() {
            if ( $(this).prop('checked') == true ) {
                $($(this).data('child-class')).prop('checked', true);
            } else {
                $($(this).data('child-class')).prop('checked', false);
            }
        });

        //-- 個別チェックがクリックされたとき
        $('div.people_list input[type=checkbox]').on('click', function() {
            //-- ※check_listを増減させる
            if( $(this).prop('checked') ) {
                //増加
            } else {
                //削減
            } 

            //-- 全チェックになった時と、その逆の動作
            let f_all_check = true;
            $('.'+$(this).data('group')).each(function(index, element){
                if( element.checked == false ) f_all_check = false;
            });
            $('#' + $(this).data('group') + '-all-check').prop('checked', f_all_check);
        });
    </script>

</html>
