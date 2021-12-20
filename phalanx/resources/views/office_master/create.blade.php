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
                <div class="col-md-5">
                    <label for="officename" class="form-element">事業所名</label>
                    <input type="text" id="officename" name="office_name" class="w-100 form-control form-element" value="{{ old('office_name') }}">
                    @if ($errors->has("office_name"))
                        <ul class="pl-0" style="list-style: none">
                            @foreach ($errors->get("office_name") as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="col-md-5">
                    <label for="enOfficeName" class="form-element">英語事業所名</label>
                    <input type="text" id="enOfficeName" name="en_office_name" class="w-100 form-control form-element" value="{{ old('en_office_name') }}">
                    @error("en_office_name")
                        <ul class="pl-0" style="list-style: none">
                            @foreach ($errors->get("en_office_name") as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label for="sort" class="form-element">表示順</label>
                    <input type="number" id="sort" name="sort" class="w-100 form-control form-element" value="{{ old('sort') }}">
                    @if ($errors->has("sort"))
                        <ul class="pl-0" style="list-style: none">
                            @foreach ($errors->get("sort") as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="登録">
        <a href="{{ route('office.index') }}" class="btn btn-secondary back-button">戻る</a>
    </form>
</div>

@endsection