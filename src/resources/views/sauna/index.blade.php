<!-- main.blade.phpの継承 -->
@extends('layouts.sauna.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'サウナ一覧')

<!-- header.blade.php の読み込み -->
@include('layouts.sauna.header')

<!-- sidebar.blade.php の読み込み -->
@include('layouts.sauna.sidebar')

@section('contents')
{{-- 一般ユーザー向けサウナ一覧 --}}
<h1>おすすめサウナ一覧</h1>
<div class="sauna-grid">
@foreach ($saunas as $sauna)
    <div class="sauna-card">
        <div class="sauna-image-wrapper">
            @if($sauna->firstImage)
                <img src="{{ Storage::url($sauna->firstImage->file_path) }}" alt="{{ $sauna->name }}">
            @else
                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">
                    No Image
                </div>
            @endif
        </div>

        <div class="sauna-info">
            <h3 style="margin: 0 0 8px 0;">{{ $sauna->name }}</h3>

            <p class="sauna-description">
                {{ $sauna->description ?? 'サウナの説明がここに表示されます。' }}
            </p>

            <a href="{{ url('sauna/'.$sauna->id) }}" class="btn-detail">
                詳細を見る
            </a>
        </div>
    </div>
@endforeach
</div>@endsection
