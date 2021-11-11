@extends('layouts.app')
@section('css')
    <link href="{{ asset('css/index-table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/trial-application-manager/index.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <h3 class="page_title">体験・見学申込管理　一覧</h3>
        <form action="{{ route('trial_application_manage.index') }}" method="GET">
            @csrf
            <div class="form-group">
                <div class="row justify-content-start mx-auto my-2">
                    <label for="office_id" class="text-md-left label">事業所</label>
                    <select class="form-select @error('office_id') is-invalid @enderror" name="office_id">
                        <option value="">選択してください</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}" @if ($office->id == old('office_id', $office_id ?? '')) selected @endif>
                                {{ $office->office_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('office_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="col2"></div>
                </div>
                <div class="row justify-content-start mx-auto my-2">
                    <label for="office_id" class="text-md-left label">確認状況</label>
                    <div class="form-select">
                        <span class="form-select-element">
                            <input id="check_yet" name="check_yet" type="checkbox" @if ($check_yet) checked @endif>
                            <label class="form-check-label" for="check_yet">未</label>
                        </span>
                        <span class="form-select-element">
                            <input id="check_done" name="check_done" type="checkbox" @if ($check_done) checked @endif>
                            <label class="form-check-label" for="check_done">済</label>
                        </span>
                    </div>
                    @error('check_yet')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @error('check_done')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input class="text-md-right filter-button" type="submit" value="絞り込み">
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="table-header">
                    <th class="table-header-sub">申請日</th>
                    <th class="table-header-sub">事業所</th>
                    <th class="table-header-sub">体験希望日</th>
                    <th>氏名</th>
                    <th class="table-header-sub-mini">確認状況</th>
                    <th class="table-header-sub">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trial_applications as $trial_application)
                    @php
                        $application_date = new Carbon\Carbon($trial_application->created_at);
                        $desired_date = new Carbon\Carbon($trial_application->desired_date);
                    @endphp
                    <tr>
                        <td>{{ $application_date->isoFormat('YYYY年MM月DD日 (ddd)') }}</td>
                        <td>{{ $trial_application->office->office_name }}</td>
                        <td>{{ $desired_date->isoFormat('YYYY年MM月DD日 (ddd)') }}</td>
                        <td>{{ Illuminate\Support\Facades\Crypt::decryptString($trial_application->name) }}</td>
                        <td>
                            @if ($trial_application->is_checked)
                                済
                            @else
                                <span class="text-danger font-weight-bold">未</span>
                            @endif
                        </td>
                        <td>
                            <div class="table-body-action">
                                <span>
                                    <a class="btn btn-sm btn-success" role="button"
                                        href="{{ route('trial_application_manage.check', $trial_application->id) }}">確認</a>
                                </span>
                                <div>
                                    <a class="btn btn-sm btn-primary" role="button"
                                        href="{{ route('trial_application_manage.edit', $trial_application->id) }}">編集</a>
                                </div>
                                <form class="delete-form"
                                    action="{{ route('trial_application_manage.destroy', $trial_application->id) }}"
                                    method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-danger" type="submit">削除</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $trial_applications->appends(request()->query())->links() }}
        <p>
            <a class="btn btn-secondary" role="button" href="{{ route('home') }}">ホームに戻る</a>
        </p>
    </div>
@endsection
