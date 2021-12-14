@extends('trial_application_form.common')

@section('page_title', 'フォーム')

@section('form')
    <form action="{{ route('trial_application_form.store') }}" method="post">
    @csrf
@endsection

@section('submit_button')
<button class="btn btn-primary" type="submit">申請</button>
@endsection

@section('back_button')
<a href="{{ route('top') }}" class="btn btn-secondary back-button">トップに戻る</a>
@endsection