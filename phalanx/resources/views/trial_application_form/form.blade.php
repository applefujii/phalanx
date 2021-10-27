@extends('trial_application_form.common')

@section('page_title', 'フォーム')

@section('form')
    <form action="{{ route('trial_application_form.store') }}" method="post">
    @csrf
@endsection

@section('button_name', '申請')

@section('back_button')
    <a class="btn btn-outline-primary" role="button" href="{{ route('home') }}">取り消し</a>
@endsection