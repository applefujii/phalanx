@extends('trial_application_form.common')

@section('page_title', ' 編集')

@section('form')
    <form action="{{ route('trial_application_manage.update', $trial_application->id) }}" method="post">
        @method('PATCH')
        @csrf
@endsection

@section('submit_button')
<button class="btn btn-primary" type="submit">編集</button>
@endsection

@section('back_button')
<a href="{{ session()->get('index_url.trial_application_manage') ?? route('trial_application_manage.index') }}" class="btn btn-secondary back-button">キャンセル</a>
@endsection