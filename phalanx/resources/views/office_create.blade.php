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
  <!-- <link rel="stylesheet" href="office.css"> -->
  <link href="{{asset('/css/office.css?202111041116')}}" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-light bg-dark  ml-auto">
  <b>タイトル</b>
</nav><br>
<div class="container">
    <h3>事業所マスタ　新規登録</h3><br>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <div class="row justify-content-start mx-auto my-4">
                <div class="form-col">
                    <label for="name" class="text-md-left form-element">事業所名</label><br />
                    <input type="text" id="name" class="form-control form-element @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-col">
                    <label for="name_katakana" class="text-md-left form-element">表示順</label><br />
                    <input type="text" id="name_katakana" class="form-control form-element @error('name_katakana') is-invalid @enderror" name="name_katakana" value="{{ old('name_katakana') }}" required>
                    @error('name_katakana')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>


        <input type="submit" class="btn btn-primary mr-3" value="登録"><a href="{{ route('user.index') }}" class="btn btn-secondary back-button">戻る</a>
    </form>
</div>


@endsection
</body>