@extends('layouts.app')


@section('css')
    <link href="{{ asset('css/index-table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/aptitude_question_manage.css') }}" rel="stylesheet">
@endsection

@section('title')適性診断質問管理 @yield('page_title')@endsection

@section('content')
<div class="container">
    <h3>適性診断質問管理 @yield('page_title')</h3>
    @if ($errors->any())
    <div class="alert alert-danger w-100">
        <span>入力に誤りがあります。</span>
    </div>
    @endif
    <div class="mb-4">
        <span>※点数に『F』を指定すると、回答が『はい』の場合、合計点数に関わらずその事業所に確定されます。</span>
        <br>
        <span>　点数が空欄の場合は0点と判断されます。</span>
    </div>
    @yield('form_upper')
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead class="table-header-width">
                    <tr class="table-header">
                        <th rowspan="2" class="align-middle" style="width: 30%">質問文</th>
                        <th rowspan="2" class="align-middle">表示順</th>
                        <th colspan="{{ count($offices) }}" class="align-middle">点数</th>
                        @if (\Route::current() -> getName() === 'aptitude_question_manage.index')
                            <th rowspan="2" class="align-middle">操作</th> 
                        @endif
                    </tr>
                    <tr class="table-header">
                        @foreach($offices as $office)
                            <th class="align-middle">{{ $office->office_name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @yield('table_body')
                </tbody>
            </table>
        </div>
    @yield('form_under')
</div>
@endsection