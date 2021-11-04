@extends('aptitude_question_form.result.common')

@section('office_name', 'アップル梅田')
@section('trial_form')
    <a class="btn btn-outline-primary" role="button" href="{{ route('trial_application_form.index', ['office_id' => 1]) }}">体験・見学申し込みへ</a>
@endsection
