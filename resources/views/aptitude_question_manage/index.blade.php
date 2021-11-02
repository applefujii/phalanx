@extends('layouts.app')
@section('content')
<h3 class="page_title">適性診断管理　一覧</h3>
<div class="card">
    <div class="card-header"></div>
    <div class="card-body">
        <p>
            <a class="btn btn-outline-primary" role="button" href="{{ route('aptitude_question_manage.create') }}">新規作成</a>
            <a class="btn btn-outline-primary" role="button" href="{{ route('aptitude_question_manage.create') }}">編集</a>
        </p>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped blue_table member_table">
                <thead>
                    <tr>
                        <th rowspan="2">質問文</th>
                        <th rowspan="2">表示順</th>
                        <th colspan="3">点数</th>
                        <th rowspan="2">操作</th>
                    </tr>
                    <tr>
                        <th>アップル</th>
                        <th>ミント</th>
                        <th>メープル</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aptitude_questions as $aptitude_question)
                    <tr class="@error("questions.$aptitude_question->id") table-danger @enderror">
                        <td>{{ $aptitude_question->question }}</td>
                        <td>{{ $aptitude_question->sort }}</td>
                        <td>{{ $aptitude_question->score_apple }}</td>
                        <td>{{ $aptitude_question->score_mint }}</td>
                        <td>{{ $aptitude_question->score_maple }}</td>
                        <td>
                            <form action="{{ route('aptitude_question_manage.destroy', $aptitude_question->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-primary" type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p>
            <a class="btn btn-outline-primary" role="button" href="{{ route('home') }}">メニュー</a>
        </p>
    </div>
</div>
@endsection