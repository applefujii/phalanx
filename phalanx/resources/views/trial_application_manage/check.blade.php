@extends('trial_application_form.common')

@section('page_title', ' 確認')

@section('form')
    <form action="{{ route('trial_application_manage.check', $trial_application->id) }}" method="post">
        @method('PATCH')
        @csrf
@endsection


@section('submit_button')
    @if ($trial_application->is_checked)
        <button class="btn btn-success" type="submit">連絡未に戻す</button>
    @else
        <button class="btn btn-success" type="submit">連絡済にする</button>
    @endif
@endsection

@section('back_button')
<a href="{{ session()->get('index_url.trial_application_manage') ?? route('trial_application_manage.index') }}" class="btn btn-secondary back-button">取り消し</a>
@endsection
