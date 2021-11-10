@extends('trial_application_form.common')

@section('page_title', '編集')

@section('form')
    <form action="{{ route('trial_application_manage.update', $trial_application->id) }}" method="post">
        @method('PATCH')
        @csrf
@endsection

@section('button_name', '更新')

@section('back')
href="{{ route('trial_application_manage.index') }}"
@endsection