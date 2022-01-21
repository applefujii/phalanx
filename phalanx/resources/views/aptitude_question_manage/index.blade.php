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
    @php
        $scores = explode(",", $aptitude_questions[$q_count]["scores"]);
        for($i=0 ; $i<count($offices) ; $i++) {
            if(!isset($scores[$i])) $scores[$i] = 0;
            echo "<td>".$scores[$i]."</td>";
        }
    @endphp
    <td>
        <div class="table-body-action row">
            <div class="col-12 col-md-6 px-0 py-1">
                <a class="btn btn-sm btn-primary" role="button edit-button"
                    href="{{ route('aptitude_question_manage.edit', $aptitude_question->id) }}">編集</a>
            </div>
            <form class="delete-form col-12 col-md-6 px-0 py-1"
                action="{{ route('aptitude_question_manage.destroy', $aptitude_question->id) }}"
                method="post">
                @method('DELETE')
                @csrf
                <button class="btn btn-sm btn-danger" type="submit"
                    onclick="return confirm('削除しますか\nID: {{ $aptitude_question->id }}\n質問文: {{ $aptitude_question->question }}\n表示順: {{ $aptitude_question->sort }}\nアップル点数: {{ $aptitude_question->score_apple }}\nミント点数: {{ $aptitude_question->score_mint }}\nメープル点数: {{ $aptitude_question->score_maple }}')">
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