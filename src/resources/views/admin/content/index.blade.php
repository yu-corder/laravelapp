<!-- main.blade.phpの継承 -->
@extends('layouts.admin.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'コンテンツ一覧')

<!-- header.blade.php の読み込み -->
@include('layouts.admin.header')

<!-- sidebar.blade.php の読み込み -->
@include('layouts.admin.sidebar')

<!-- 'contents'という名称で他のBladeからの呼び出しを可能にする -->
@section('contents')
<h1>コンテンツ</h1>
<h2>サウナ検索</h2>
<form action="{{ url('item') }}" method="get">
    <div>
        <input class="input-border" type="text" name="name" placeholder="サウナ名">
        <button class="search-btn" type="submit">検索</button>
    </div>
</form>

<h2>コンテンツ一覧</h2>
<div>
    <a href="{{ url('admin/content/add') }}">コンテンツ登録</a>
</div>
@endsection
