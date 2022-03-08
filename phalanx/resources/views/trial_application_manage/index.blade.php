@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/index-table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/trial_application_manager.scss') }}" rel="stylesheet">
@endsection

@section('title')体験・見学申込管理 一覧@endsection

@section('content')
    <div class="container">
        <h3 class="page_title">体験・見学申込管理 一覧</h3>
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
                    <label class="text-md-left label">本人への連絡</label>
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
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr class="table-header">
                        <th class="table-header-sub">申請日</th>
                        <th class="table-header-sub">事業所</th>
                        <th class="table-header-sub">体験希望日</th>
                        <th>氏名</th>
                        <th class="table-header-sub">本人への連絡</th>
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
                                <div class="table-body-action row">
                                    <span class="col-12 col-md-4 px-0 py-1">
                                        <a class="btn btn-sm btn-success" role="button"
                                            href="{{ route('trial_application_manage.check', $trial_application->id) }}">連絡</a>
                                    </span>
                                    <div class="col-12 col-md-4 px-0 py-1">
                                        <a class="btn btn-sm btn-primary @if ($trial_application->is_checked) disabled @endif" role="button"
                                            href="{{ route('trial_application_manage.edit', $trial_application->id) }}">編集</a>
                                    </div>
                                    <form class="delete-form col-12 col-md-4 px-0 py-1"
                                        action="{{ route('trial_application_manage.destroy', $trial_application->id) }}"
                                        method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-danger" type="submit"
                                            onclick="return moveCheck('{{ $application_date->isoFormat('YYYY年MM月DD日 (ddd)') }}', '{{ $trial_application->office->office_name }}', '{{ $desired_date->isoFormat('YYYY年MM月DD日 (ddd)') }}', '{{ Illuminate\Support\Facades\Crypt::decryptString($trial_application->name) }}', {{ $trial_application->is_checked }})">
                                        削除</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $trial_applications->appends(request()->query())->links('vendor/pagination/pagination_view') }}
        {{-- <p>
            <a class="btn btn-secondary" role="button" href="{{ route('user_page') }}">ホームに戻る</a>
        </p> --}}
    </div>
@endsection

@section("script")
<script>
function moveCheck(a_date, office, d_date, name, check) {
    let con = false;
    if (check == 1) {
        con = confirm(`削除しますか\n申請日: ${a_date}\n事業所: ${office}\n体験希望日: ${d_date}\n氏名: ${name}\n本人への連絡: 済`);
    } else {
        con = confirm(`削除しますか\n申請日: ${a_date}\n事業所: ${office}\n体験希望日: ${d_date}\n氏名: ${name}\n本人への連絡: 未`);
    }

    if(con == false) {
        return false;
    } else if (check == 0) {
        return confirm("本人への連絡が済んでいませんが本当に削除しますか");
    } else {
        return true;
    }
}
</script>
@endsection