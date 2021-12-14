@extends('aptitude_question_manage.common2')

@section('page_title', '新規登録')

@section('form')
<form action="{{ route('aptitude_question_manage.store') }}" method="post">
    @csrf
@endsection

@section('button_name', '登録')

@section('back_button')
    <a class="btn btn-outline-primary" role="button" href="{{ route('trial_application_manage.index') }}">取り消し</a>
@endsection