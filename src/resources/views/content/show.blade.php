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
@endsection
