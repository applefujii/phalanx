@extends('trial_application_form.common')

@section('page_title', ' 確認')

@section('form')
    <form action="{{ route('trial_application_manage.check', $trial_application->id) }}" method="post">
        @method('PATCH')
        @csrf
@endsection

@if ($trial_application->is_checked)
    @section('button_name', '確認未に戻す')
@else
    @section('button_name', '確認済にする') 
@endif

@section('back')
href="{{ route('trial_application_manage.index') }}"
@endsection

@section('back_name', '取り消し')