<div class="bg-white col-12">
    <h2 class="text-center mt-2">予定</h2>
    <div class="notifications">
        @if ($notifications_groups->count() === 0)
            <div class="notification-card border border-secondary rounded p-2">
                <span>予定はありません</span>
            </div>
        @else
            @php
                $i = 0;
            @endphp
            @foreach ($notifications_groups as $key => $notifications)
                @if ($key !== '期限切れ')
                    <div class="date_category my-2 position-relative d-flex justify-content-center">
                        <button class="btn btn-light d-flex align-items-center" data-toggle="collapse" data-target="#collapse_{{ $i }}" aria-expanded="false">
                            {{ $key }}
                        </button>
                        <hr class="position-absolute" color="black" width="100%">
                    </div>
                    <div id="collapse_{{ $i }}" class="collapse show">
                        @foreach ($notifications as $notification)
                            @php
                                $start_at = new Carbon\Carbon($notification->start_at);
                                $end_at = new Carbon\Carbon($notification->end_at);
                                if ($notification->date_if_allday()) {
                                    $start_at = $start_at->isoFormat('YYYY年MM月DD日(ddd)');
                                    $end_at = $end_at->isoFormat('YYYY年MM月DD日(ddd)');
                                } else {
                                    $start_at = $start_at->isoFormat('YYYY年MM月DD日(ddd) HH:mm');
                                    $end_at = $end_at->isoFormat('YYYY年MM月DD日(ddd) HH:mm');
                                }
                            @endphp
                            <div class="notification-card border border-secondary rounded p-2">
                                <span>{{ $start_at }}</span>
                                <br class="d-block d-md-none">
                                <span> ～ {{ $end_at }}</span>
                                <div class="p-2">
                                    <span class="notification-content">{{ $notification->content }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @php
                    $i++;
                @endphp
            @endforeach
        @endif
    </div>
    <div class="d-md-none">
        <span class="m-2"></span>
    </div>
</div>