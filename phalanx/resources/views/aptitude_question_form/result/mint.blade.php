@extends('aptitude_question_form.result.common')

@section('office_name', 'ミント大阪')

@section('contents')
<img src="{{ asset('image/mint.png') }}" alt="ミント大阪">
@endsection

@section('trial_form')
<a class="btn btn-outline-primary" role="button" href="{{ route('trial_application_form.index',['office_id' => 2]) }}">体験・見学申し込みへ</a>
@endsection
