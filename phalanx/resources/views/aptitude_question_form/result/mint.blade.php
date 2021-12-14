@extends('aptitude_question_form.result.common')

@section('office_name', 'ミント大阪')

@section('logo')
src="{{ asset('css/images/mint.png') }}"
@endsection

@section('official')
href="https://mint-osaka.jp/"
@endsection

@section('trial_form')
href="{{ route('trial_application_form.index', ['office_id' => 2]) }}"
@endsection
