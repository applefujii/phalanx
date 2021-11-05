@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">あなたにおすすめの事業所は、@yield('office_name')です！</div>

                <div class="card-body">
                    @yield('contents')
                </div>
                
                <p>
                    @yield('trial_form')
                    <a class="btn btn-outline-primary" role="button" href="{{ route('home') }}">メニュー</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection