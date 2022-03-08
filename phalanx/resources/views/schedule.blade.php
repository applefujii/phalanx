<div class="bg-white col-12">
    <h2 class="text-center mt-2">予定</h2>
    <div class="notifications">
        @if ($notifications_groups->count() === 0)
            <div class="notification-card border border-secondary rounded">
                <div class="m-2">
                    <div class="m-2">
                        <span class="notification-content">予定はありません</span>
                    </div>
                </div>
            </div>
            <img src="{{ asset('css/images/nashi.png') }}" alt="予定なし" class="notification-content-image">
        @else
            @php
                $i = 0;
            @endphp
            @foreach ($notifications_groups as $key => $notifications)
                <div class="date_category my-2 position-relative d-flex justify-content-center">
                    <button class="btn btn-light d-flex align-items-center" data-toggle="collapse" data-target="#collapse_{{ $i }}" aria-expanded="false">
                        {{ $key }}
                    </button>
                    <hr class="position-absolute" color="black" width="100%">
                </div>
                <div id="collapse_{{ $i }}" class="collapse show">
                    @foreach ($notifications as $notification)
                    <div class="mb-2">
                        <div class="border border-secondary rounded">
                            <div class="m-2">
                                <span>{{ $notification->full_date_format() }}</span>
                                <div class="m-2">
                                    <span class="notification-content">{{ $notification->content }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
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