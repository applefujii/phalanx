@extends('layouts.app')
@section('title', '事業所マスタ　一覧')
@section('css')
    <link href="{{ asset('css/index-table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user-master/index.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-md">
        <h3>事業所マスタ　一覧</h3>
        <div class="mb-2">
            <a href="{{ route('office.create') }}" type="button" class="btn btn-primary my-3">新規作成</a>
        </div>
        <div class="mt-3">
        <table class="table table-striped table-bordered table-sm">
            <thead class="bg-primary text-white">
                <tr class="table-header">
                    <th class="table-header-sub" style="width: 40%">事業所名</th>
                    <th class="table-header-sub" style="width: 20%">表示順</th>
                    <th class="table-header-sub" style="width: 20%">適性診断の優先順位</th>
                    <th class="table-header-sub" style="width: 20%">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offices as $office)
                    <tr>
                        <td class="main-td">{{ $office->office_name }}</td>
                        <td class="main-td">{{ $office->sort }}</td>
                        <td class="main-td">{{ $office->priority }}</td>
                        <td class="">
                            <div class="table-body-action"><span><a href="{{ route('office.edit', $office->id) }}"
                                        type="button" class="btn btn-sm btn-primary edit-button">編集</a></span>
                                <form method="post" action="{{ route('office.destroy', $office->id) }}"> @csrf
                                    @method('DELETE') <button type="submit"
                                        class="btn btn-sm btn-danger delete-button" onclick='@if($office->id == Auth::user()->office_id) alert("自身のアカウントを削除できないように制限しています"); return false; @else return confirm("削除しますか\nID: {{ $office->id }}\n事業所名: {{ $office->office_name }}\n表示順: {{ $office->sort }}"); @endif'>削除</button></form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <a class="btn btn-secondary" role="button" href="{{ route('user_page') }}">ホームに戻る</a> --}}
        </div>
    </div>

@endsection

