<!-- main.blade.phpの継承 -->
@extends('layouts.sauna.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'サウナ一覧')

<!-- header.blade.php の読み込み -->
@include('layouts.sauna.header')

<!-- sidebar.blade.php の読み込み -->
@include('layouts.sauna.sidebar')

@section('contents')
<div class="ck-content">
    {!! $content->body !!}
</div>

<style>
.ck-content h2 {
    border-left: 5px solid #007bff;
    padding-left: 15px;
    /* 管理画面で設定したスタイルをここにコピー */
}
.ck-content img {
    max-width: 100%;
    height: auto;
}
</style>
@endsection
