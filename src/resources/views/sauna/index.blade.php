@extends('layouts.sauna.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'サウナ一覧')

@include('layouts.sauna.header')

@include('layouts.sauna.sidebar')

@section('contents')
<h2>おすすめサウナ一覧</h2>
<div class="sauna-grid">
@forelse ($saunas as $sauna)
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

            @if($sauna->rating)
                <div class="sauna-rating">
                    <div class="sauna-rating-flex">
                        <span class="sauna-rating-star">★</span>
                        <span class="sauna-rating-score">
                            {{ number_format($sauna->rating->total_score, 1) }}
                        </span>
                    </div>
                </div>
            @endif

            <p class="sauna-description">
                {{ $sauna->description ?? 'サウナの説明がここに表示されます。' }}
            </p>

            @if($sauna->contents->isNotEmpty())
                <a href="{{ route('contents.show', $sauna->contents->first()->id) }}" class="btn-detail">
                    詳細を見る
                </a>
            @else
                <span class="btn-detail disabled" style="background: #ccc; cursor: not-allowed;">
                    準備中
                </span>
            @endif
        </div>
    </div>
@empty
    <div class="empty-messages">
        <p class="empty-message">{{ __('messages.empty_state.description') }}</p>
    </div>
@endforelse
</div>
@endsection
