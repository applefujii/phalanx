@extends('layouts.app')
@section('content')
<h3 class="page_title">体験・見学申込管理　一覧</h3>
<div class="card">
    <div class="card-header">絞り込み条件</div>
    <div class="card-body">
        <form action="{{ route('trial_application_manage.index') }}" method="GET">
        @csrf
            <div class="form-group row">
                <label for="office_id" class="col-form-label col-auto">事業所</label>
                <select
                    class="form-control @error("office_id") is-invalid @enderror"
                    name="office_id"
                >
                    <option value="">選択してください</option>
                    @foreach ($offices as $office)
                    <option value="{{ $office->id }}" @if ($office->id == old('office_id', $office_id ?? "")) selected @endif>
                        {{ $office->office_name }}
                    </option>
                    @endforeach
                </select>
                @error("office_id")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group row">
                <label for="office_id" class="col-form-label col-auto">確認状況</label>
                <div class="form-check col-auto">
                    <input id="check_yet" name="check_yet" class="form-check-input" type="checkbox" @if ($check_yet) checked @endif>
                    <label class="form-check-label" for="check_yet">未</label>
                </div>
                <div class="form-check col-auto">
                    <input id="check_done" name="check_done" class="form-check-input" type="checkbox" @if ($check_done) checked @endif>
                    <label class="form-check-label" for="check_done">済</label>
                </div>
                @error("check_yet")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @error("check_done")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="col-auto">
                    <input class="btn btn-primary" type="submit" value="絞り込み">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">一覧表示</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped blue_table member_table">
                <thead>
                    <tr>
                        <th>申請日</th>
                        <th>事業所</th>
                        <th>体験希望日</th>
                        <th>氏名</th>
                        <th>確認状況</th>
                        <th>操作</th>
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
                        <td>{{ $trial_application->name }}</td>
                        <td>
                            @if ($trial_application->is_checked)
                                済
                            @else
                                未
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-outline-primary" role="button" href="{{ route('trial_application_manage.check', $trial_application->id) }}">確認</a>
                            <a class="btn btn-outline-primary" role="button" href="{{ route('trial_application_manage.edit', $trial_application->id) }}">修正</a>
                            <a class="btn btn-outline-primary" role="button" href="{{ route('trial_application_manage.destroy', $trial_application->id) }}">削除</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
		{{ $trial_applications->appends(request()->query())->links() }}
        <p>
            <a class="btn btn-outline-primary" role="button" href="{{ route('home') }}">メニュー</a>
        </p>
    </div>
</div>
@endsection