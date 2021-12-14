@extends('aptitude_question_manage.common2')

@section('page_title', '編集')

@section('form')
<form action="{{ route('aptitude_question_manage.update', $aptitude_question->id) }}" method="post">
    @method('PATCH')
    @csrf
@endsection

@section('button_name', '更新')

@section('back_button')
    <a class="btn btn-outline-primary" role="button" href="{{ route('trial_application_manage.index') }}">取り消し</a>
@endsection