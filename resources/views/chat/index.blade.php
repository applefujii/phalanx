@extends('layouts.app')

@section('css')
<link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{-- <pre><?php var_dump($chat_texts->toArray()); ?></pre> --}}
    
    <div class="mx-5 pb-5 row">

        <div class="col-sm-2">
            <div>
                <span>＃{{ $chat_room->room_title }}</span>
            </div>
        </div>

        <div class="chat_main col-sm-8">
            
        @if ($errors->any())
            <div class="alert alert-danger w-100">
                <span>入力に誤りがあります。</span>
            </div>
            @endif
            
            <div>
                <span>＃{{ $chat_room->room_title }}</span>
            </div>
            <hr>

            @foreach ($chat_texts as $chat_text)
            @php
                $created_at = new \Carbon\Carbon($chat_text->created_at);
            @endphp
                <div>
                    <span class="text-danger">{{ $chat_text->user->name }}</span>　{{ $created_at->isoFormat('YYYY年MM月DD日(ddd) HH:mm') }}
                </div>
                <div class="chat_text ml-2">
                    <p>{{ $chat_text->chat_text }}</p>
                </div>
            @endforeach

            <div class="chat_input_fixed">
                <form action="{{ route('chat.store', $chat_room->id) }}" method="post" class="form-row">
                    @csrf
                    <div class="col">
                        <textarea id="chat_text" class="form-control  @error('chat_text') is-invalid @enderror" name="chat_text"
                        >{{ old('chat_text') }}
                        </textarea>
                    </div>
                    <div class="col">
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

        <div class="col-sm-2">
            <div>
                <span>＃{{ $chat_room->room_title }}</span>
            </div>
        </div>
    </div>
@endsection
