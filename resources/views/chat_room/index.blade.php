@extends("chat_room.sidebar")
@section("c_css")

@endsection

@section('center')
<div class="container-fluid pt-3">
    <h3>通所者一覧</h3>
    <div class="d-flex flex-column text-center">
        @foreach ($offices as $office)
            <div class="d-flex flex-column">
                <div>
                    ───<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#{{ $office->en_office_name }}Collapse">
                        <i class="fas fa-chevron-down"></i>{{ $office->office_name }}
                    </button>───
                </div>
                <div class="collapse" id="{{ $office->en_office_name }}Collapse">
                    
                </div>
            </div>
        @endforeach
        <div>
            ───<button type="button" class="btn btn-link"><i class="fas fa-chevron-down"></i>体験</button>───
        </div>
    </div>
</div>
@endsection