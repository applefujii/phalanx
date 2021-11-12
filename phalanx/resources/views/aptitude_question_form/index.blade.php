@extends('layouts.app')

@section('title', '適性診断')

@section('css')
<link href="{{ asset('css/aptitude_question_form.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <h3 class="text-center">適性診断</h3>
        @if ($errors->any())
            <div class="alert alert-danger w-100">
                <span>未回答の質問があります。</span>
            </div>
        @endif
        <form action="{{ route('aptitude_question_form.calculate') }}" method="post">
            @csrf
            @foreach ($aptitude_questions as $aptitude_question)
            <div class="justify-content-center aptitude_question row">
                <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][id]"
                    value="{{ $aptitude_question->id }}">
                <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_apple]"
                    value="{{ $aptitude_question->score_apple ?? 0 }}">
                <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_mint]"
                    value="{{ $aptitude_question->score_mint ?? 0 }}">
                <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_maple]"
                    value="{{ $aptitude_question->score_maple ?? 0 }}">

                <div class="question col-md-5 p-3">
                    {{ $aptitude_question->question }}
                </div>
                <div class="answer col-md-4 row p-3">
                    @foreach (config('const.option') as $option_key => $option_value)
                        <div class="radio col-md-auto">
                            <div class="form-check">
                            <input id="{{ $option_key }}[{{ $aptitude_question->id }}]"
                                class="form-check-input" type="radio"
                                name="aptitude_questions[{{ $aptitude_question->id }}][answer]"
                                value="{{ $option_value }}"
                                @if (!is_null(old("aptitude_questions.$aptitude_question->id.answer")) && (int) old("answers.$aptitude_question->id.answer") === $option_value) checked @endif>
                            <label class="form-check-label"
                                for="{{ $option_key }}[{{ $aptitude_question->id }}]">{{ config('const.option_japanese')[$option_key] }}</label>
                            </div>
                        </div>
                    @endforeach
                    @error("aptitude_questions.$aptitude_question->id.answer")
                        <p class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                    @enderror
                </div>
            </div>
            @endforeach

            <div class="form-group text-center">
                <button class="btn btn-primary" type="submit">結果を見る</button>
            </div>
        </form>
        <p class="text-center">
            <a class="btn btn-secondary" role="button" href="{{ route('top') }}">トップに戻る</a>
        </p>
    </div>
@endsection
