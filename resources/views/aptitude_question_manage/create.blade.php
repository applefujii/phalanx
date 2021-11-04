@extends('aptitude_question_manage.common')
@section('title', '一括編集')

@section('form_upper')
<form action="{{ route('aptitude_question_manage.store') }}" method="post">
    @csrf
@endsection

@section('table_body')
<tr>
    <td>
        <input
            id="question"
            class="form-control @error("question") is-invalid @enderror" 
            type="text"
            name="question" 
            value="{{ old("question") }}"
        >
        @error("question")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="sort"
            class="form-control @error("sort") is-invalid @enderror"
            type="text"
            name="sort"
            value="{{ old("sort") }}"
        >
        @error("sort")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="score_apple"
            class="form-control @error("score_apple") is-invalid @enderror"
            type="text"
            name="score_apple"
            value="{{ old("score_apple") }}"
        >
        @error("score_mint")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="score_mint"
            class="form-control @error("score_mint") is-invalid @enderror"
            type="text"
            name="score_mint"
            value="{{ old("score_mint") }}"
        >
        @error("score_mint")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
    <td>
        <input
            id="score_maple"
            class="form-control @error("score_maple") is-invalid @enderror"
            type="text"
            name="score_maple"
            value="{{ old("score_maple") }}"
        >
        @error("score_maple")
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </td>
</tr>
@endsection

@section('form_under')
    <div class="form-group">
        <button class="btn btn-primary" type="submit">登録</button>
        @yield('back_button')
    </div>
</form>
@endsection