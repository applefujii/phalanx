@extends('errors::minimal-customize')

@section('title', '503 | ' . __('Service Unavailable'))
@section('image')
    <img src="{{ asset('css/images/error-image.png') }}" height="200">
@endsection
@section('code', '503 | ' . __('Service Unavailable'))
@section('message', 'サーバーからの応答がありません。時間を空けてアクセスしてください。')
@section('link')
    <a href="./">TOPへ戻る</a>
@endsection
