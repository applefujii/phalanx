@extends('layouts.app')
@section('content')
<h3 class="page_title">適性診断質問管理　@yield('page_title')</h3>
<div class="card">
    @if ($errors->any())
    <div class="alert alert-danger w-100">
        <span>入力に誤りがあります。</span>
    </div>
    @endif
        <div class="card-body">

            @yield('form')
                    <div class="form-row">
                        <label for="question">質問文</label>
                        <input
                            id="question"
                            class="form-control @error("question") is-invalid @enderror" 
                            type="text"
                            name="question" 
                            value="{{ old("question", $aptitude_question->question ?? '') }}"
                        >
                        @error("question")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <label for="sort">表示順</label>
                        <input
                            id="sort"
                            class="form-control @error("sort") is-invalid @enderror"
                            type="text"
                            name="sort"
                            value="{{ old("sort", $aptitude_question->sort ?? '') }}"
                        >
                        @error("sort")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <p>点数</p>
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label for="score_apple">アップル梅田</label>
                            <input
                                id="score_apple"
                                class="form-control @error("score_apple") is-invalid @enderror"
                                type="text"
                                name="score_apple"
                                value="{{ old("score_apple", $aptitude_question->score_apple ?? '') }}"
                            >
                            @error("score_apple")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="score_mint">ミント大阪</label>
                            <input
                                id="score_mint"
                                class="form-control @error("score_mint") is-invalid @enderror"
                                type="text"
                                name="score_mint"
                                value="{{ old("score_mint", $aptitude_question->score_mint ?? '') }}"
                            >
                            @error("score_mint")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-3">
                            <label for="score_maple">メープル関西</label>
                            <input
                                id="score_maple"
                                class="form-control @error("score_maple") is-invalid @enderror"
                                type="text"
                                name="score_maple"
                                value="{{ old("score_maple", $aptitude_question->score_maple ?? '') }}"
                            >
                            @error("score_maple")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">@yield('button_name')</button>
                    <a class="btn btn-outline-primary" role="button" href="{{ route('aptitude_question_manage.index') }}">取り消し</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection