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
  <link rel="stylesheet" href="office.css">
</head>

<body>

<nav class="navbar navbar-light bg-dark  ml-auto">
  <b>タイトル</b>
</nav><br>

@extends('layout.app')

@section('content')
<button type="button" class="mypage btn btn-warning">マイページ</button>
<b class="list float-left">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp事業所マスタ　一覧</b><br>

&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-primary">新規作成</button><br>
&nbsp

<div class="container">
  <div class="row">
    <div class="col-lg-0">
  </div>
<div class="col-lg-12">
<br><table class="table table-striped table-bordered table-hover">
<thead class="thead-dark">
  <tr>
    <th class="text-center">事業所名</th>
    <th class="text-center">表示順</th>
    <th class="text-center">操作</th>
  </tr>
</thead>

  <tr>
  @foreach ($offices as $office)
    <td style="width: 40%">{{ $office->office_name }}</td>
    <td style="width: 30%">{{ $office->sort }}</td>
    <td class="text-center" style="width: 30%"><button type="button" class="btn btn-primary">編集</button>
    <button type="button" class="btn btn-primary">削除</button></td>
  </tr>

  @endforeach

  <!-- <tr>
    <td>{{ $office->office_name }}</td>
    <td>{{ $office->sort }}</td>
    <td class="text-center"><button type="button" class="btn btn-primary">編集</button>
    <button type="button" class="btn btn-primary">削除</button></td>
  </tr> -->
  @endforeach
</table>
@endsection

    </div>
    </div>
    </div>
</body>