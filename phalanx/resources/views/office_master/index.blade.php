@extends('layouts.app')

@section('title', '事業所マスター　一覧')
@section('css')
    <link href="{{ asset('css/index-table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user-master/index.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <h3>事業所マスター　一覧</h3>
        <a href="{{ route('office.create') }}" type="button" class="btn btn-primary">新規作成</a>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="table-header">
                    <th class="table-header-sub">事業所名</th>
                    <th class="table-header-sub">表示順</th>
                    <th class="table-header-sub">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offices as $office)
                    <tr>
                        <td>{{ $office->office_name }}</td>
                        <td>{{ $office->sort }}</td>
                        <td>
                            <div class="table-body-action"><span><a href="{{ route('office.edit', $office->id) }}"
                                        type="button" class="btn btn-sm btn-primary edit-button">編集</a></span>
                                <form method="post" action="{{ route('office.destroy', $office->id) }}"> @csrf
                                    @method('DELETE') <button type="submit"
                                        class="btn btn-sm btn-danger delete-button" onclick='@if($office->id == Auth::id()) alert("自身のアカウントを削除できないように制限しています"); return false; @else return confirm("削除しますか\nID: {{ $office->id }}\n事業所名: {{ $office->name }}\n表示順: {{ $office->sort }}"); @endif'>削除</button></form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
