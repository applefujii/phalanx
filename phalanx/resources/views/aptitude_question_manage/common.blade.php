@extends('layouts.app')
@section('content')
<h3 class="page_title">適性診断管理　@yield('title')</h3>
<div class="card">
    @if ($errors->any())
    <div class="alert alert-danger w-100">
        <span>入力に誤りがあります。</span>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card-header"></div>
    <div class="card-body">
        @yield('form_upper')
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped blue_table member_table">
                    <thead>
                        <tr>
                            <th rowspan="2">質問文</th>
                            <th rowspan="2">表示順</th>
                            <th colspan="3">点数</th>
                            @if (\Route::current() -> getName() === 'aptitude_question_manage.index')
                                <th rowspan="2">操作</th> 
                            @endif
                        </tr>
                        <tr>
                            <th>アップル</th>
                            <th>ミント</th>
                            <th>メープル</th>
                        </tr>
                    </thead>
                    <tbody>
                        @yield('table_body')
                    </tbody>
                </table>
            </div>
            @yield('form_under')
        <p>
            <a class="btn btn-outline-primary" role="button" href="{{ route('home') }}">メニュー</a>
        </p>
    </div>
</div>
@endsection