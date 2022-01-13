@extends('errors::minimal-customize')

@section('title', '500 | ' . __('Server Error'))
@section('image')
    <img src="{{ asset('css/images/error-image.png') }}" height="200">
@endsection
@section('code', '500 | ' . __('Server Error'))
@section('message', 'サーバーに問題が発生しています。時間を空けてアクセスしてください')
@section('link')
    <a href="./">TOPへ戻る</a>
@endsection
