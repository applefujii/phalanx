@extends('layouts.app')

@section('title')適性診断結果：@yield('office_name')@endsection

@section('css')
<link href="{{ asset('css/aptitude_result.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container text-center">
    <h3 class="mb-4">あなたにおすすめの事業所は、@yield('office_name')です！</h3>

    <img @yield('logo') alt="@yield('office_name')" class="logo">
    
    <p><a class="btn btn-primary mt-4 col-md-2" role="button" @yield('official')>公式サイト</a></p>
    <p><a class="btn btn-primary col-md-2" role="button" @yield('trial_form')>体験・見学申し込み</a></p>
    <p><a class="btn btn-secondary col-md-2" role="button" href="{{ route('top') }}">トップに戻る</a></p>
</div>
@endsection