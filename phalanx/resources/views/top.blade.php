@extends('layouts.app')

@section('title', 'ファランクス　トップ')

@section('css')
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="main_contents">
            <h3 class="text-center m-4">こちらは、株式会社リテラル福祉事業部が運営する<br/>就労福祉サービス事業所とのコミュニケーションツールとなります。</h3>
            <h3 class="text-center m-4">ご興味のある方は、下記の適性診断よりご自身に合った事業所をご確認ください。</h3>
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <a class="d-flex justify-content-center" href="https://apple-osaka.com/" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('css/images/apple.png') }}" alt="アップル梅田" class="logo">
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a class="d-flex justify-content-center" href="https://mint-osaka.jp/" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('css/images/mint.png') }}" alt="ミント大阪" class="logo">
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a class="d-flex justify-content-center" href="https://maple-osaka.jp/" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('css/images/maple.png') }}" alt="メープル関西" class="logo">
                    </a>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <span class="mb-2">自分に合った事業所を見つけましょう</span>
            </div>
            <div class="d-flex justify-content-center">
                <a class="btn btn-success col-md-3 mb-4" role="button" href="{{ route('aptitude_question_form.index') }}">適性診断</a>
            </div>
            <div class="d-flex justify-content-center">
                <span class="mb-2">体験・見学の申し込みはこちら</span>
            </div>
            <div class="d-flex justify-content-center">
                <a class="btn btn-primary col-md-3" role="button" href="{{ route('trial_application_form.index') }}">体験・見学申し込み</a>
            </div>
        </div>
    </div>
</div>

@endsection