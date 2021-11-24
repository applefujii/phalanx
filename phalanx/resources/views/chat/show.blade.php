@extends('chat.sidebar')

@section('css')
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection

@section('center')
    <div id="chat_main">
        <div id="chat_header" class="border col-md-8 d-flex align-items-center">
            <span id="room_name">
        </div>

        <div id="chat_log">
        </div>

        <div id="bottom">
        </div>

        <div id="new">
            <span id="new_message" class="alert alert-success justify-content-center">新着があります。</span>
        </div>

        <div id="error">
            <span id="error_message" class="alert alert-danger d-flex align-items-center">エラーがあります。</span>
        </div>

        <div id="chat_footer" class="border col-md-8 d-flex align-items-center p-0">
            <div class="form-row col-12">
                <div class="col-10">
                    <textarea id="chat_text" name="chat_text" class="form-control chat_textarea @error('chat_text') is-invalid @enderror" rows="1" required="required">{{ old('chat_text') }}</textarea>
                    @error('chat_text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-2">
                    <button id="submit" class="btn btn-primary">送信</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
    <script>
        // チャットルームID
        let chat_room_id = @json($chat_room->id);
        // ログイン者のユーザー情報
        const user = @json(Auth::user());
    </script>
    <script src="{{ asset('js/chat.js') }}"></script>
@endsection
