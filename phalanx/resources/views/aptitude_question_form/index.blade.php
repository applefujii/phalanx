@extends('layouts.app')

@section('title', '適性診断')

@section('content')
<div class="container">
    <h3>適性診断</h3>
    @if ($errors->any())
    <div class="alert alert-danger w-100">
        <span>未回答の質問があります。</span>
    </div>
    @endif
    <form action="{{ route('aptitude_question_form.calculate') }}" method="post">
        @csrf
        <table class="table table-bordered table-hover table-striped blue_table member_table">
            <tbody>
                @foreach ($aptitude_questions as $aptitude_question)
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][id]" value="{{ $aptitude_question->id }}">
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_apple]" value="{{ $aptitude_question->score_apple ?? 0 }}">
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_mint]" value="{{ $aptitude_question->score_mint ?? 0 }}">
                    <input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][score_maple]" value="{{ $aptitude_question->score_maple ?? 0 }}">
                        
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-6">
                                    {{ $aptitude_question->question }}
                                </div>
                                <div class="d-md-none">
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    @foreach (config('const.option') as $option_key => $option_value)
                                        <div class="form-check form-check-inline">
                                            <input
                                                id="{{ $option_key }}[{{ $aptitude_question->id }}]"
                                                class="form-check-input"
                                                type="radio"
                                                name="aptitude_questions[{{ $aptitude_question->id }}][answer]"
                                                value="{{ $option_value }}" 
                                                @if (!is_null(old("aptitude_questions.$aptitude_question->id.answer")) && (int)old("answers.$aptitude_question->id.answer") === $option_value ) checked @endif
                                            >
                                            <label class="form-check-label" for="{{ $option_key }}[{{ $aptitude_question->id }}]">{{ config('const.option_japanese')[$option_key] }}</label>
                                        </div>
                                    @endforeach
                                    @error("aptitude_questions.$aptitude_question->id.answer")
                                        <p class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="form-group text-center">
            <button class="btn btn-primary" type="submit">結果を見る</button>
        </div>
    </form>
    <p class="text-center">
        <a class="btn btn-secondary" role="button" href="{{ route('top') }}">トップに戻る</a>
    </p>
</div>
@endsection