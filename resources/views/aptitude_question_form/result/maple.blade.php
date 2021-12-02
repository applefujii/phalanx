@extends('aptitude_question_form.result.common')

@section('office_name', 'メープル関西')

@section('logo')
src="{{ asset('css/images/maple.png') }}"
@endsection

@section('trial_form')
href="{{ route('trial_application_form.index', ['office_id' => 3]) }}"
@endsection
