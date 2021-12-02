@extends('layouts.app')

@section('css')
@yield("c_css")
@endsection

@section("content")
<body>

    <h1>APIテストページ</h1>
    <div class="d-flex frex-row">
        <div class="container" style="width: 50%;">
            <button id="api1" type="button" class="btn btn-primary">API1</button>
            <textarea class="result m-2" rows="20" style="display: block; width: 100%;"></textarea>
        </div>
        <div class="container" style="width: 50%;">
            <button id="api2" type="button" class="btn btn-primary">API2</button>
            <textarea class="result m-2" rows="20" style="display: block; width: 100%;"></textarea>
        </div>
    </div>

</body>
@endsection


@section('script')
{{-- jQuery読み込み --}}
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

<script>

    var siteUrl = "{{ config('const.url') }}";

    //-- 読み込まれたタイミングで実行
    $(function(){

        //-- ajaxの規定値を設定
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //--------------- APIのテスト

        $("#api1").on('click', function(){
            $.ajax({
                type: "POST",
                url: siteUrl + "api/v1.0/set/notifications.json", // 送り先
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
                $("#api1").parent().children('.result').val(param);
                console.log(param);
                })
            .fail( function(XMLHttpRequest, textStatus, errorThrown){   // エラーが起きた時はこちらが実行される
                $("#api1").parent().children('.result').val(XMLHttpRequest);    // エラー内容表示
                console.log(param);
            });
        });

        $("#api2").on('click', function(){
            $.ajax({
                type: "POST",
                url: siteUrl + "api/v1.0/get/users.json", // 送り先
                data: {},   // 渡したいデータをオブジェクトで渡す
                dataType : "json",  // データ形式を指定
                scriptCharset: 'utf-8'  // 文字コードを指定
            })
            .done( function(param){     // paramに処理後のデータが入って戻ってくる
                $("#api2").parent().children('.result').val(JSON.stringify(param));
                console.log(param);
            })
            .fail( function(XMLHttpRequest, textStatus, errorThrown){   // エラーが起きた時はこちらが実行される
                $("#api2").parent().children('.result').val(param);
                console.log(param);
            });
        });

    });

</script>

@yield("c_script")
@endsection
