@extends('layouts.app')
@section('title', '事業所マスター　新規登録')
@section('css')
<link href="{{ asset('css/user-master/create_and_edit.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <h3>事業所マスター　新規登録</h3>
    <form method="POST" action="{{ route('office.store') }}">
        @csrf

        <div class="form-group">
            <div class="row justify-content-start mx-auto my-4">
                <div class="mx-4">
                    <label for="text" class="text-md-left form-element">事業所名</label><br />
                    <input type="text" id="text" class="form-control form-element @error('text') is-invalid @enderror" name="office_name" value="{{ old('office_name') }}" autofocus>
                    @error('office_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mx-4">
                    <label for="text" class="text-md-left form-element">表示順</label><br />
                    <input type="number" id="number" class="form-control form-element" name="sort">
                </div>
            </div>

        <input type="submit" class="btn btn-primary" value="登録"><a href="{{ route('office.index') }}" class="btn btn-secondary back-button">戻る</a>
    </form>
</div>

@endsection