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

        //-- API1
        $("#api1").on('click', function(){
            $.ajax({
                type: "PUT",
                url: siteUrl + "api/v1.0/set/offices.json", // 送り先
                data: {
                    records : [
                        { id:2,office_name : "リテラル天神橋", en_office_name : "a",sort :200}
                    ]
                },   // 渡したいデータをオブジェクトで渡す
                dataType : "json",  // データ形式を指定
                scriptCharset: 'utf-8'  // 文字コードを指定
            })
            .done( function(param){     // paramに処理後のデータが入って戻ってくる
                $("#api1").parent().children('.result').val(jsonMolding(param));
                console.log(param);
                })
            .fail( function(XMLHttpRequest, textStatus, errorThrown){   // エラーが起きた時はこちらが実行される
                $("#api1").parent().children('.result').val('!!!!!!!! error !!!!!!!!!\n\n'+XMLHttpRequest.responseText);    // エラー内容表示
                console.log(XMLHttpRequest);
            });
        });

        //-- API2
        $("#api2").on('click', function(){
            $.ajax({
                type: "POST",
                url: siteUrl + "api/v1.0/get/chatExistUnread.json", // 送り先
                data: {
                    record : {
                    }
                },   // 渡したいデータをオブジェクトで渡す
                dataType : "json",  // データ形式を指定
                scriptCharset: 'utf-8'  // 文字コードを指定
            })
            .done( function(param){     // paramに処理後のデータが入って戻ってくる
                $("#api2").parent().children('.result').val(jsonMolding(param));
                console.log(param);
            })
            .fail( function(XMLHttpRequest, textStatus, errorThrown){   // エラーが起きた時はこちらが実行される
                $("#api2").parent().children('.result').val('!!!!!!!! error !!!!!!!!!\n\n'+XMLHttpRequest.responseText);
                console.log(XMLHttpRequest);
            });
        });

    });

    //-- json成形
    function jsonMolding(json) {
        let str
        if( typeof(json) == 'object' ) str = JSON.stringify(json);
        else if( typeof(json) != 'String' ) str = json;
        str = str.replace(/(\]}])(?! *?, *?\n)/g, '$1\n');
        str = str.replace(/([\[{,])(?! *?\n)/g, '$1\n');
        str = str.replace(/([\]}])/g, '\n$1');
        let row = str.split('\n');
        let depth = 0;
        let n;
        str = '';
        for( let i=0 ; i<row.length ; i++ ) {
            n = row[i].match(/[\]}]/g);
            if( n != null ) {
                depth -= n.length;
            }
            
            row[i] = row[i].trim();
            for( let j=0 ; j<depth ; j++ ) str += '\t';
            
            n = row[i].match(/[\[{]/g);
            if( n != null ) {
                depth += n.length;
            }

            str += row[i] + '\n';
        }
        return str;
    }

</script>

@yield("c_script")
@endsection
