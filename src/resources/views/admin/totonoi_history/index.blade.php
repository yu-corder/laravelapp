<!-- main.blade.phpの継承 -->
@extends('layouts.admin.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'サ活履歴')

<!-- header.blade.php の読み込み -->
@include('layouts.admin.header')

<!-- sidebar.blade.php の読み込み -->
@include('layouts.admin.sidebar')

<!-- 'contents'という名称で他のBladeからの呼び出しを可能にする -->
@section('contents')
<h2>サウナ検索</h2>
<form action="{{ url('item') }}" method="get">
    <div>
        <input class="input-border" type="text" name="name" placeholder="サウナ名">
        <button class="search-btn" type="submit">検索</button>
    </div>
</form>

<h2>サ活履歴</h2>
<div class="calender-header-group">
    <div class="calendar-paging-group">
        <a class="calender-month" href="{{ route('admin.totonoi_history.index', ['month' => $prevMonth]) }}"><< 前月</a>
        <span class="current-month">{{ $currentDate->format('Y年m月') }}</span>
        <a class="calender-month" href="{{ route('admin.totonoi_history.index', ['month' => $nextMonth]) }}">>> 次月</a>
    </div>
    <div style="font-size: 1.1em; color: #114c81; font-weight: bold;">
        今月のサ活代合計: <span style="font-size: 1.3em; color: #3ab0cf;">&yen;{{ number_format($totalPrice) }}</span>
    </div>
</div>
<div>
    @include('admin.totonoi_history._calendar')
</div>
@endsection
