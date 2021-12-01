@extends('layouts.app')

@section('title', '事業所マスター　一覧')
@section('css')
    <link href="{{ asset('css/office-table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user-master/index.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-md">
        <h3>事業所マスター　一覧</h3>
        <a href="{{ route('office.create') }}" type="button" class="btn btn-primary my-3">新規作成</a>
        <table class="table table-striped table-bordered table-sm">
            <thead class="bg-primary text-white">
                <tr class="table-header text-center">
                    <th class="table-header-sub col-xs-3 col-ms-3 col-md-4 col-lg-4" style="width: 20%">事業所名</th>
                    <th class="table-header-sub col-xs-3 col-ms-3 col-md-3 col-lg-4" style="width: 20%">表示順</th>
                    <th class="table-header-sub col-xs-1 col-ms-1 col-md-1 col-lg-1">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offices as $office)
                    <tr>
                        <td class="text-center">{{ $office->office_name }}</td>
                        <td class="text-center">{{ $office->sort }}</td>
                        <td class="text-center">
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
