@extends('trial_application_form.common')

@section('page_title', 'フォーム')

@section('form')
    <form action="{{ route('trial_application_form.store') }}" method="post">
    @csrf
@endsection

@section('button_name', '申請')

@section('back')
href="{{ route('top') }}"
@endsection

@section('back_name', 'トップに戻る')