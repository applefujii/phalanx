@extends('trial_application_form.common')

@section('page_title', 'フォーム')

@section('form')
    <form action="{{ route('trial_application_form.store') }}" method="post">
    @csrf
@endsection

@section('button_name', '申請')

@section('back_button')
    <p><a class="btn btn-outline-primary" role="button" href="{{ route('top') }}">トップに戻る</a></p>
@endsection