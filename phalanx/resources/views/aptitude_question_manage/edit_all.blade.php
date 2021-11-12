@extends('aptitude_question_manage.common')

@section('page_title', '一括編集')

@section('form_upper')
<form action="{{ route('aptitude_question_manage.update_all') }}" method="post">
    @method('PATCH')
    @csrf
@endsection

@section('table_body')
@foreach ($aptitude_questions as $aptitude_question)
<input type="hidden" name="aptitude_questions[{{ $aptitude_question->id }}][id]" value="{{ $aptitude_question->id ?? '' }}">
<tr>
    <td>
        <input
            id="aptitude_questions[{{ $aptitude_question->id }}][question]"
            class="form-control @error("aptitude_questions.$aptitude_question->id.question") is-invalid @enderror" 
            type="text"
            name="aptitude_questions[{{ $aptitude_question->id }}][question]" 
            value="{{ old("aptitude_questions.$aptitude_question->id.question", $aptitude_question->question ?? '') }}"
        >
        @error("aptitude_questions.$aptitude_question->id.question")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="aptitude_questions[{{ $aptitude_question->id }}][sort]"
            class="form-control @error("aptitude_questions.$aptitude_question->id.sort") is-invalid @enderror"
            type="text"
            name="aptitude_questions[{{ $aptitude_question->id }}][sort]"
            value="{{ old("aptitude_questions.$aptitude_question->id.sort", $aptitude_question->sort ?? '') }}"
        >
        @error("aptitude_questions.$aptitude_question->id.sort")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="aptitude_questions[{{ $aptitude_question->id }}][score_apple]"
            class="form-control @error("aptitude_questions.$aptitude_question->id.score_apple") is-invalid @enderror"
            type="text"
            name="aptitude_questions[{{ $aptitude_question->id }}][score_apple]"
            value="{{ old("aptitude_questions.$aptitude_question->id.score_apple", $aptitude_question->score_apple ?? '') }}"
        >
        @error("aptitude_questions.$aptitude_question->id.score_apple")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="aptitude_questions[{{ $aptitude_question->id }}][score_mint]"
            class="form-control @error("aptitude_questions.$aptitude_question->id.score_mint") is-invalid @enderror"
            type="text"
            name="aptitude_questions[{{ $aptitude_question->id }}][score_mint]"
            value="{{ old("aptitude_questions.$aptitude_question->id.score_mint", $aptitude_question->score_mint ?? '') }}"
        >
        @error("aptitude_questions.$aptitude_question->id.score_mint")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="aptitude_questions[{{ $aptitude_question->id }}][score_maple]"
            class="form-control @error("aptitude_questions.$aptitude_question->id.score_maple") is-invalid @enderror"
            type="text"
            name="aptitude_questions[{{ $aptitude_question->id }}][score_maple]"
            value="{{ old("aptitude_questions.$aptitude_question->id.score_maple", $aptitude_question->score_maple ?? '') }}"
        >
        @error("aptitude_questions.$aptitude_question->id.score_maple")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
</tr>
@endforeach
@endsection

@section('form_under')
    <div class="form-group">
        <button class="btn btn-primary" type="submit">更新</button>
        <a class="btn btn-secondary" role="button" href="{{ route('aptitude_question_manage.index') }}">取り消し</a>
    </div>
</form>
@endsection