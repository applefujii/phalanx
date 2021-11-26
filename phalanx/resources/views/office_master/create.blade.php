@extends('layouts.app')
@section('title', '事業所マスター　新規登録')
@section('css')
<link href="{{ asset('css/user-master/create_and_edit.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-md">
    <h3>事業所マスター　新規登録</h3>
    <form method="POST" action="{{ route('office.store') }}">
        @csrf
        <div class="form-group">
            <div class="row justify-content-start mx-auto my-4">
                <div class="mx-4">
                    <label for="text" class="text-md-left form-element">事業所名</label><br>
                    <input type="text" id="officename" name="office_name" class="form-control form-element" value="{{ old('office_name') }}"><br>
                @if ($errors->has("office_name"))
                   <!--  <div class="row mt-2">
                        <ul class="pl-0" style="list-style: none"> -->
                            @foreach ($errors->get("office_name") as $error)
                            <li class="text-danger">{{ $error }}</li> 
                            @endforeach
                        <!-- </ul>
                    </div> -->
                @endif
                </div>
                <div class="mx-4">
                    <label for="text" class="text-md-left form-element">表示順</label><br>
                    <input type="number" id="sort" name="sort" class="form-control form-element" value="{{ old('sort') }}"><br>
                @if ($errors->has("sort"))
                    <!-- <div class="row mt-2"> -->
                        <!-- <ul class="pl-0" style="list-style: none"> -->
                                @foreach ($errors->get("sort") as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                        <!-- </ul> -->
                    <!-- </div> -->
                @endif
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="登録"><a href="{{ route('office.index') }}" class="btn btn-secondary back-button">戻る</a>
    </form>
</div>

@endsection