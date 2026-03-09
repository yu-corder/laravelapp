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
<div class="sauna-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
    @foreach ($saunas as $sauna)
        <div class="sauna-card" style="border: 1px solid #ddd; border-radius: 12px; overflow: hidden; background: #fff;">
            {{-- メイン画像 --}}
            <div class="sauna-image" style="height: 200px; background: #eee;">
                @if($sauna->firstImage)
                    <img src="{{ Storage::url($sauna->firstImage->path) }}"
                         style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">
                        No Image
                    </div>
                @endif
            </div>

            {{-- サウナ情報 --}}
            <div class="sauna-info" style="padding: 15px;">
                <h3 style="margin: 0 0 10px 0;">{{ $sauna->name }}</h3>
                <p style="font-size: 14px; color: #666;">{{ Str::limit($sauna->description, 50) }}</p>

                {{-- 以前実装した評価スコアがあれば表示 --}}
                @if($sauna->rating)
                    <div class="score" style="color: #e67e22; font-weight: bold;">
                        ★ {{ $sauna->rating->totonoi_score }}
                    </div>
                @endif

                <a href="{{ url('sauna/'.$sauna->id) }}" style="display: block; margin-top: 15px; text-align: center; background: #007bff; color: #fff; text-decoration: none; padding: 8px; border-radius: 6px;">
                    詳細を見る
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
