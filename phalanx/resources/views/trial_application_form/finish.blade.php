@extends('layouts.app')

@section('title')体験・見学申込 申請完了@endsection

@section('content')
<div class="container text-center">
    <div class="m-4">
        <h3>申請が完了しました。</h3>
        <p></p>
        <h3>担当者からの連絡をお待ちください。</h3>
    </div>
    
    <p><a class="btn btn-secondary" role="button" href="{{ route('top') }}">トップに戻る</a></p>
</div>
@endsection
