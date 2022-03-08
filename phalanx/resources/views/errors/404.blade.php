@extends('errors::minimal-customize')

@section('title', '404 | ' . __('Not Found'))
@section('image')
    <img src="{{ asset('css/images/error-image.png') }}" height="200">
@endsection
@section('code', '404 | ' . __('Not Found'))
@section('message', '存在しないページです。')
@section('link')
    <a href="./">TOPへ戻る</a>
@endsection
