@extends('errors::minimal-customize')

@section('title', '419 | ' . __('Page Expired'))
@section('image')
    <img src="{{ asset('css/images/error-image.png') }}" height="200">
@endsection
@section('code', '419 | ' . __('Page Expired'))
@section('message', 'タイムアウトしました。もう一度やり直してください。')
@section('link')
    <a href="./">TOPへ戻る</a>
@endsection
