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
                    <div class="aptitude_question row">
                        <div class="question col-lg-7 p-3">
                            {{ $aptitude_question->question }}
                        </div>
                        <div class="answer col-lg-5 row p-3 d-flex justify-content-end">
                            @foreach (config('const.option') as $option_key => $option_value)
                                <div class="radio col-lg-auto">
                                    <div class="form-check d-flex align-items-baseline">
                                        <input type="hidden" name="answers[{{ $aptitude_question->id }}][id]" value="{{ $aptitude_question->id }}">
                                        <input id="answers_{{ $aptitude_question->id }}_{{ $option_key }}"
                                            class="form-check-input @error('answers.{{ $aptitude_question->id }}.answer') is-invalid @enderror" type="radio"
                                            name="answers[{{ $aptitude_question->id }}][answer]"
                                            value="{{ $option_value }}"
                                            @if ( old("answers.$aptitude_question->id.answer", "") === (string) $option_value)
                                                checked
                                            @endif
                                        >
                                        <label class="form-check-label" for="answers_{{ $aptitude_question->id }}_{{ $option_key }}">{{ config('const.option_japanese')[$option_key] }}</label>
                                    </div>
                                    @error("answers.{{ $aptitude_question->id }}.answer")
                                        <p class="text-danger pl-3" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>
                            @endforeach
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
