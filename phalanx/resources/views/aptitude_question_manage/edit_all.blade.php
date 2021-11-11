@extends('aptitude_question_manage.common')

@section('page_title', '一括編集')

@section('form_upper')
<form action="{{ route('aptitude_question_manage.update_all') }}" method="post">
    @method('PATCH')
    @csrf
@endsection

@section('table_body')
@foreach ($aptitude_questions as $aptitude_question)
<tr>
    <td>
        <input
            id="questions[{{ $aptitude_question->id }}]"
            class="form-control @error("questions.$aptitude_question->id") is-invalid @enderror" 
            type="text"
            name="questions[{{ $aptitude_question->id }}]" 
            value="{{ old("questions.$aptitude_question->id", $aptitude_question->question ?? '') }}"
        >
        @error("questions.$aptitude_question->id")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="sorts[{{ $aptitude_question->id }}]"
            class="form-control @error("sorts.$aptitude_question->id") is-invalid @enderror"
            type="text"
            name="sorts[{{ $aptitude_question->id }}]"
            value="{{ old("sorts.$aptitude_question->id", $aptitude_question->sort ?? '') }}"
        >
        @error("sorts.$aptitude_question->id")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="score_apples[{{ $aptitude_question->id }}]"
            class="form-control @error("score_apples.$aptitude_question->id") is-invalid @enderror"
            type="text"
            name="score_apples[{{ $aptitude_question->id }}]"
            value="{{ old("score_apples.$aptitude_question->id", $aptitude_question->score_apple ?? '') }}"
        >
        @error("score_apples.$aptitude_question->id")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="score_mints[{{ $aptitude_question->id }}]"
            class="form-control @error("score_mints.$aptitude_question->id") is-invalid @enderror"
            type="text"
            name="score_mints[{{ $aptitude_question->id }}]"
            value="{{ old("score_mints.$aptitude_question->id", $aptitude_question->score_mint ?? '') }}"
        >
        @error("score_mints.$aptitude_question->id")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="score_maples[{{ $aptitude_question->id }}]"
            class="form-control @error("score_maples.$aptitude_question->id") is-invalid @enderror"
            type="text"
            name="score_maples[{{ $aptitude_question->id }}]"
            value="{{ old("score_maples.$aptitude_question->id", $aptitude_question->score_maple ?? '') }}"
        >
        @error("score_maples.$aptitude_question->id")
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