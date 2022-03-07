@extends('aptitude_question_manage.common')

@section('page_title', '一覧')

@section('form_upper')
<p>
    <a class="btn btn-primary" role="button" href="{{ route('aptitude_question_manage.create') }}">新規作成</a>
    <a class="btn btn-primary" role="button" href="{{ route('aptitude_question_manage.edit_all') }}">一括編集</a>
</p>
@endsection

@section('table_body')
@foreach ($aptitude_questions as $q_count => $aptitude_question)
<tr class="@error("questions.$aptitude_question->id") table-danger @enderror">
    <td>{{ $aptitude_question->question }}</td>
    <td>{{ $aptitude_question->sort }}</td>
    @foreach ($aptitude_question->scores->sortBy('office.sort') as $score)
        <td>{{ $score->score }}</td>
    @endforeach
    <td>
        <div class="table-body-action">
            <form class="delete-form"
                action="{{ route('aptitude_question_manage.destroy', $aptitude_question->id) }}"
                method="post">
                @method('DELETE')
                @csrf
                <button class="btn btn-sm btn-danger" type="submit"
                    onclick="return confirm('削除しますか？')">
                削除</button>
            </form>
        </div>
    </td>
</tr>
@endforeach
@endsection

@section('form_under')
{{-- <p><a class="btn btn-secondary" role="button" href="{{ route('user_page') }}">ホームに戻る</a></p> --}}
@endsection
