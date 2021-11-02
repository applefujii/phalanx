@extends('layouts.app')
@section('content')
<h3 class="page_title">適性診断</h3>
<div class="card">
    @if ($errors->any())
    <div class="alert alert-danger w-100">
        <span>入力に誤りがあります。</span>
    </div>
    @endif
    <div class="card-header"></div>
    <div class="card-body">
        <form action="{{ route('aptitude_question_form.calculate') }}" method="post">
            @csrf

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped blue_table member_table">
                    <tbody>
                        @foreach ($aptitude_questions as $aptitude_question)
                        <input type="hidden" name="score_apples[{{ $aptitude_question->id }}]" value="{{ $aptitude_question->score_apple }}">
                        <input type="hidden" name="score_mints[{{ $aptitude_question->id }}]" value="{{ $aptitude_question->score_mint }}">
                        <input type="hidden" name="score_maples[{{ $aptitude_question->id }}]" value="{{ $aptitude_question->score_maple }}">
                        <tr class="@error("questions.$aptitude_question->id") table-danger @enderror">
                            <td>{{ $aptitude_question->question }}</td>
                            <td>
                                @foreach (config('const.option') as $option_key => $option_value)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="questions[{{ $aptitude_question->id }}]" id="{{ $option_key }}[{{ $aptitude_question->id }}]" value="{{ $option_value }}" @if (!is_null(old("questions.$aptitude_question->id")) && (int)old("questions.$aptitude_question->id") === $option_value ) checked @endif>
                                    <label class="form-check-label" for="{{ $option_key }}[{{ $aptitude_question->id }}]">{{ config('const.option_japanese')[$option_key] }}</label>
                                </div>
                                @endforeach
                                @error("questions.$aptitude_question->id")
                                    <p class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                @enderror
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">結果を見る</button>
            </div>
        </form>
        <p>
            <a class="btn btn-outline-primary" role="button" href="{{ route('home') }}">メニュー</a>
        </p>
    </div>
</div>
@endsection