@extends('aptitude_question_manage.common')
@section('title', '一覧')

@section('form_upper')
<p>
    <a class="btn btn-outline-primary" role="button" href="{{ route('aptitude_question_manage.create') }}">新規作成</a>
    <a class="btn btn-outline-primary" role="button" href="{{ route('aptitude_question_manage.edit') }}">一括編集</a>
</p>
@endsection

@section('table_body')
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
@endsection

@section('form_under')
@endsection