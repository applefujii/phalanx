@extends('chat.sidebar')

@section('c_css')
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection

@section('center')
<div id="center-scroll">
    <div id="chat_header" class="border col-md-8 d-flex align-items-center">
        <span id="room_name">
    </div>

    <div id="chat_main" class="col-md-8">
        <div id="chat_scroll">
            <div id="chat_log">
            </div>
        </div>
    </div>

    <div id="to_bottom" class="col-md-8 pl-0">
        <div class="col-md-12 d-flex pl-0">
            <div class="ml-auto">
                <button id="to_bottom_button" class="btn btn-secondary rounded-circle">
                    <svg xmlns="{{ asset('image/chevron-double-down.svg') }}" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
                        <path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="new" class="bg-success">
        <span id="new_message" class="text-light m-0">新着があります</span>
    </div>
    <div id="error" class="bg-danger">
        <span id="error_message" class="text-light m-0">エラーがあります</span>
    </div>

    <div id="chat_footer" class="border col-md-8 m-0 p-0">
        <div class="col-12 p-0">
            <button id="footer_button_open" type="button" class="btn btn-outline-secondary btn-block rounded-0 m-0 p-0">
                <i class="fas fa-chevron-up"></i>
            </button>
            <button id="footer_button_close" type="button" class="btn btn-outline-secondary btn-block rounded-0 m-0 p-0">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        <div class="d-flex align-items-center p-0">
            <div class="form-row col-12 pt-2">
                <textarea id="chat_text" name="chat_text" class="form-control border border-primary col-11" rows="1"></textarea>
                <div class="col-1">
                    <button id="submit" class="btn btn-primary rounded-circle">
                        <svg xmlns="{{ asset('image/send-fill.svg') }}" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89.471-1.178-1.178.471L5.93 9.363l.338.215a.5.5 0 0 1 .154.154l.215.338 7.494-7.494Z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('c_script')
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script>
    // チャットルームID
    let chat_room_id = @json($chat_room->id);
    // ログイン者のユーザー情報
    const auth_user_id = @json(Auth::user()->id);
    const auth_user_type_id = @json(Auth::user()->user_type_id);
    const auth_office_name = @json(Auth::user()->office->office_name);
</script>
<script src="{{ asset('js/chat.min.js') }}"></script>
@endsection
