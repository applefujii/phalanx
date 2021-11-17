@extends('layouts.app')
@section('content')

<!--@author Yubaru Nozato-->

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" 
    crossorigin="anonymous">
    <link rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" 
    crossorigin="anonymous">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">
  <link href="{{asset('/css/user_page.css?202111124')}}" rel="stylesheet">
</head>

<body>
@if (Auth::user()->user_type_id === 2 or Auth::user()->user_type_id === 3)
<br>
<a href="{{ route('chat_room.index') }}" type="button" class="btn btn-primary text-center d-flex 
align-items-center justify-content-center rounded"><h1>チ ャ ッ ト</h1></a>
<div class="line"></div>
<h3 class="scj">予定</h3>
<div class="txt">
&nbsp&nbsp2020/03/16 12:45～<br>
&nbsp&nbsp2020/03/16 14:30<br><br>

&nbsp&nbspアップル梅田体験

</div>
@endif

@if (Auth::user()->user_type_id === 1)
<br>
<a href="{{ route('chat_room.index') }}" type="button" class="btnb btn-primary text-center d-flex 
align-items-center justify-content-center rounded"><h1>チ ャ ッ ト</h1></a>
<a href="{{ route('office.create') }}" type="button" class="tkn btn-primary text-center d-flex 
align-items-center justify-content-center rounded"><h4>体験・見学申込一覧</h4></a>
<a href="{{ route('office.create') }}" type="button" class="mst btn-primary text-center d-flex 
align-items-center justify-content-center rounded"><h4>マスタ管理</h4></a>
<a href="{{ route('chat_room.list') }}" type="button" class="room btn-primary text-center d-flex 
align-items-center justify-content-center rounded"><h4>チャットルーム管理</h4></a>


<div class="line"></div>
<h3 class="scjb">予定</h3>
<div class="txtb">
&nbsp&nbsp2020/03/16 12:45～<br>
&nbsp&nbsp2020/03/16 14:30<br><br>

&nbsp&nbspミント大阪体験

</div>

@endif
</body>
@endsection