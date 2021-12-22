@extends('layouts.app')

@section('title', '適性診断')

@section('css')
    <link href="{{ asset('css/aptitude_question_form.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="col-lg-10">
            <h3 class="">適性診断</h3>
        </div>
        @if ($errors->any())
            <div class="col-lg-10">
                <div class="alert alert-danger justify-content-center">
                    <span>未回答の質問があります。</span>
                </div>
            </div>
        @endif
        <form action="{{ route('aptitude_question_form.calculate') }}" method="post">
            @csrf
            <div class="justify-content-center col-lg-10">
            @foreach ($aptitude_questions as $aptitude_question)
                <div class="aptitude_question row">
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][id]"
                        value="{{ $aptitude_question->id }}">
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_apple]"
                        value="{{ $aptitude_question->score_apple ?? 0 }}">
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_mint]"
                        value="{{ $aptitude_question->score_mint ?? 0 }}">
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_maple]"
                        value="{{ $aptitude_question->score_maple ?? 0 }}">

                    <div class="question col-lg-6 p-3">
                        {{ $aptitude_question->question }}
                    </div>
                    <div class="answer col-lg-6 row p-3">
                        @foreach (config('const.option') as $option_key => $option_value)
                            <div class="radio col-lg-auto">
                                <div class="form-check">
                                    <input id="{{ $option_key }}[{{ $aptitude_question->id }}]"
                                        class="form-check-input" type="radio"
                                        name="aptitude_questions[{{ $aptitude_question->id }}][answer]"
                                        value="{{ $option_value }}" @if (!is_null(old("aptitude_questions.$aptitude_question->id.answer")) && (int) old("aptitude_questions.$aptitude_question->id.answer") === $option_value) checked @endif>
                                    <label class="form-check-label"
                                        for="{{ $option_key }}[{{ $aptitude_question->id }}]">{{ config('const.option_japanese')[$option_key] }}</label>
                                </div>
                            </div>
                        @endforeach
                        @error("aptitude_questions.$aptitude_question->id.answer")
                            <p class="text-danger pl-3" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                        @enderror
                    </div>
                </div>
            @endforeach
            </div>

            <div class="form-group col-lg-10">
                <div class="text-center">
                    <button class="btn btn-primary" type="submit">結果を見る</button>
                </div>
            </div>
        </form>
        <div class="col-lg-10">
            <div class="text-center">
                <p><a class="btn btn-secondary" role="button" href="{{ route('top') }}">トップに戻る</a></p>
            </div>
        </div>
    </div>
@endsection
