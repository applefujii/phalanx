@extends('trial_application_form.common')

@section('page_title', '編集')

@section('form')
    <form action="{{ route('trial_application_manage.update', $trial_application->id) }}" method="post">
        @method('PATCH')
        @csrf
@endsection

@section('button_name', '更新')

@section('back_button')
    <a class="btn btn-outline-primary" role="button" href="{{ route('trial_application_manage.index') }}">取り消し</a>
@endsection