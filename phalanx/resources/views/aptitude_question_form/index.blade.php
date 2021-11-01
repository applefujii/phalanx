@extends('layouts.app')
@section('content')
<h3 class="page_title">適性診断</h3>
<div class="card">
    <div class="card-header"></div>
    <div class="card-body">
        <form action="{{ route('aptitude_question_form.calculate') }}" method="post">
            @csrf

            @foreach (config('const.category') as $category_key => $category_value)
            <p>{{ $category_key }}</p>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped blue_table member_table">
                    <tbody>
                        @foreach ($aptitude_questions as $aptitude_question)
                        <input type="hidden" name="score_apple[{{ $aptitude_question->id }}]" value="{{ $aptitude_question->score_apple }}">
                        <input type="hidden" name="score_mint[{{ $aptitude_question->id }}]" value="{{ $aptitude_question->score_mint }}">
                        <input type="hidden" name="score_maple[{{ $aptitude_question->id }}]" value="{{ $aptitude_question->score_maple }}">
                        @if ($aptitude_question->category == $category_value)
                        <tr>
                            <td>{{ $aptitude_question->question }}</td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question[{{ $aptitude_question->id }}]" id="yes[{{ $aptitude_question->id }}]" value="1">
                                    <label class="form-check-label" for="yes[{{ $aptitude_question->id }}]">はい</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question[{{ $aptitude_question->id }}]" id="no[{{ $aptitude_question->id }}]" value="-1">
                                    <label class="form-check-label" for="no[{{ $aptitude_question->id }}]">いいえ</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question[{{ $aptitude_question->id }}]" id="unclear[{{ $aptitude_question->id }}]" value="0">
                                    <label class="form-check-label" for="unclear[{{ $aptitude_question->id }}]">どちらともいえない</label>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach

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