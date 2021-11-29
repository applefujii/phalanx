@extends('chat.sidebar')

@section('c_css')
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
        
        <div id="to_bottom" class="col-md-8 p-0">
            <div class="text-right mr-4">
                <button id="to_bottom_button" class="btn btn-success">
                    <svg xmlns="{{ asset('image/chevron-double-down.svg') }}" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
                        <path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="chat_footer" class="border col-md-8 d-flex align-items-center p-0">
            <div class="form-row col-12">
                <div class="col-11">
                    <textarea id="chat_text" name="chat_text" class="form-control border border-primary chat_textarea @error('chat_text') is-invalid @enderror" rows="1" required="required">{{ old('chat_text') }}</textarea>
                    @error('chat_text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-1">
                    <button id="submit" class="btn btn-primary">
                        <svg xmlns="{{ asset('image/send-fill.svg') }}" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89.471-1.178-1.178.471L5.93 9.363l.338.215a.5.5 0 0 1 .154.154l.215.338 7.494-7.494Z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('c_script')
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
