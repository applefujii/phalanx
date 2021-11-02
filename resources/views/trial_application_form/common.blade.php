@extends('layouts.app')
@section('content')
<h3 class="page_title">体験・見学申込@yield('page_title')</h3>
<div class="card">
    @if ($errors->any())
    <div class="alert alert-danger w-100">
        <span>入力に誤りがあります。</span>
    </div>
    @endif
        <div class="card-body">

            @yield('form')
                <fieldset @if (\Route::current() -> getName() === 'trial_application_manage.check') disabled @endif>
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label for="name">氏名</label>
                            @php
                                $name = $trial_application->name ?? '';
                            @endphp
                            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $name ? Illuminate\Support\Facades\Crypt::decryptString($name) : '') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="name_kana">氏名（カナ）</label>
                            @php
                                $name_kana = $trial_application->name_kana ?? '';
                            @endphp
                            <input id="name_kana" class="form-control @error('name_kana') is-invalid @enderror" type="text" name="name_kana" value="{{ old('name_kana', $name_kana ? Illuminate\Support\Facades\Crypt::decryptString($name_kana) : '') }}">
                            @error('name_kana')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-3">
                            <label for="office_id">事業所</label>
                            <select id="office_id" class="form-control @error('office_id') is-invalid @enderror" name="office_id">
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}" @if ($office->id == old('office_id', $office_id ?? $trial_application->office_id ?? "")) selected @endif>{{ $office->office_name }}</option>
                                @endforeach
                            </select>
                            @error('office_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-3">
                            <label for="desired_date">体験・見学希望日</label>
                            <input id="desired_date" class="form-control @error('desired_date') is-invalid @enderror" type="date" name="desired_date" value="{{ old('desired_date', $trial_application->desired_date ?? '') }}">
                            @error('desired_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-3">
                            <label for="email">メールアドレス</label>
                            @php
                                $email = $trial_application->email ?? '';
                            @endphp
                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email', $email ? Illuminate\Support\Facades\Crypt::decryptString($email) : '') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="phone_number">電話番号</label>
                            @php
                                $phone_number = $trial_application->phone_number ?? '';
                            @endphp
                            <input id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" value="{{ old('phone_number', $phone_number ? Illuminate\Support\Facades\Crypt::decryptString($phone_number) : '') }}">
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">@yield('button_name')</button>
                    @yield('back_button')
                </div>
            </form>
        </div>
    </div>
</div>
@endsection