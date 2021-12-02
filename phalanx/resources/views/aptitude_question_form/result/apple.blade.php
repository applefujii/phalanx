@extends('aptitude_question_form.result.common')

@section('office_name', 'アップル梅田')

@section('logo')
src="{{ asset('css/images/apple.png') }}"
@endsection

@section('trial_form')
href="{{ route('trial_application_form.index', ['office_id' => 1]) }}"
@endsection
