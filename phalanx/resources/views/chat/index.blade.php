@extends('layouts.app')

@section('css')
<link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    {{-- <pre><?php var_dump($chat_texts->toArray()); ?></pre> --}}
    
    <div class="col-12 row">
        <div class="col-2 bg-success">
        </div>

        <div class="position-relative col-8 mb-5">
            @if ($errors->any())
            <div class="alert alert-danger w-100">
                <span>入力に誤りがあります。</span>
            </div>
            @endif
            <div>
                <span>{{ $chat_room->room_title }}</span>
            </div>

            <hr>

            @foreach ($chat_texts as $chat_text)
            @php
                $created_at = new \Carbon\Carbon($chat_text->created_at);
            @endphp
                <div>
                    <span class="text-danger">{{ $chat_text->user->name }}</span>　{{ $created_at->isoFormat('YYYY年MM月DD日(ddd) HH:mm') }}
                </div>
                <div class="white_space_pre_wrap ml-4">
                    <p>{{ $chat_text->chat_text }}</p>
                </div>
            @endforeach

            <div class="position-fixed chat_bottom bg-white w-100">
                <div class="m-2">
                    <form action="{{ route('chat.store', $chat_room->id) }}" method="post" class="form-row mx-auto">
                        @csrf
                        <div class="col-6">
                            <textarea id="chat_text" name="chat_text" class="form-control chat_textarea @error('chat_text') is-invalid @enderror" rows="1">{{ old('chat_text') }}</textarea>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">送信</button>
                        </div>
                    </form>
                    @error('chat_text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-2 bg-success">
        </div>
    </div>
</div>
@endsection
