@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/create_and_edit.css') }}" rel="stylesheet">
@endsection

@section('title')適性診断質問管理 @yield('page_title')@endsection

@section('content')
    <div class="container">
        <h3>適性診断質問管理 @yield('page_title')</h3>
        @if ($errors->any())
            <div class="alert alert-danger w-100">
                <span>入力に誤りがあります。</span>
            </div>
        @endif

        @yield('form')
            <input type="hidden" name="id" value="{{ $aptitude_question->id ?? '' }}">

            <div class="form-group">
                <div class="row justify-content-start mx-auto my-4">
                    <div class="mx-4 col-md-10">
                        <label for="question">質問文</label>
                        <input id="question" class="form-control @error('question') is-invalid @enderror" type="text"
                            name="question" value="{{ old('question', $aptitude_question->question ?? '') }}">
                        @error('question')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row justify-content-start mx-auto my-4">
                    <div class="mx-4 col-md-3">
                        <label for="sort">表示順</label>
                        <input id="sort" class="form-control @error('sort') is-invalid @enderror" type="text" name="sort"
                            value="{{ old('sort', $aptitude_question->sort ?? '') }}">
                        @error('sort')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row justify-content-start mx-auto my-4">
                    @foreach ($aptitude_question->scores->sortBy('office.sort') as $score)
                        <div class="mx-4 col-md-3">
                            <label for="score_{{ $office->en_office_name }}">{{ $office->office_name }}の点数</label>
                            <input type="hidden" name="scores[{{ $office->id }}][id]" value="{{ $score->id }}">
                            <input
                                class="form-control @error("scores.$office->id.score") is-invalid @enderror"
                                type="text"
                                name="scores[{{ $office->id }}][score]"
                                value="{{ old("scores.$office->id.score", $score->score ?? "") }}"
                            >
                            @error("scores.$office->id.score")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">@yield('button_name')</button>
                    <a class="btn btn-secondary back-button" role="button"
                        href="{{ route('aptitude_question_manage.index') }}">キャンセル</a>
                </div>
            </div>
        </form>
    </div>
@endsection
