@extends('layouts.app')

@section('title', '適性診断')

@section('css')
    <link href="{{ asset('css/aptitude_question_form.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="col-lg-12">
            <h3 class="">適性診断</h3>
            @if ($errors->any())
                <div class="col-lg-12">
                    <div class="alert alert-danger">
                        <span>未回答の質問があります。</span>
                    </div>
                </div>
            @endif
            <form action="{{ route('aptitude_question_form.calculate') }}" method="post">
                @csrf
                @foreach ($aptitude_questions as $aptitude_question)
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][id]" value="{{ $aptitude_question->id }}">
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_apple]" value="{{ $aptitude_question->score_apple ?? 0 }}">
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_mint]" value="{{ $aptitude_question->score_mint ?? 0 }}">
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_maple]" value="{{ $aptitude_question->score_maple ?? 0 }}">
                    <div class="aptitude_question row">
                        <div class="question col-lg-7 p-3">
                            {{ $aptitude_question->question }}
                        </div>
                        <div class="answer col-lg-5 row p-3 d-flex justify-content-end">
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
                <div class="text-center mt-4">
                    <button class="btn btn-primary col-lg-3" type="submit">結果を見る</button>
                </div>
            </form>
                <div class="text-center mt-3">
                    <p><a class="btn btn-secondary col-lg-3" role="button" href="{{ route('top') }}">トップに戻る</a></p>
                </div>
        </div>
    </div>
@endsection
