@extends('trial_application_form.common')

@section('page_title', ' 編集')

@section('form')
    <form action="{{ route('trial_application_manage.update', $trial_application->id) }}" method="post">
        @method('PATCH')
        @csrf
@endsection

@section('button_name', '更新')

@section('back')
href="{{ session()->get('index_url.trial_application_manage') ?? route('trial_application_manage.index') }}"
@endsection

@section('back_name', '取り消し')