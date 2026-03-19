<!-- main.blade.phpの継承 -->
@extends('layouts.admin.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'サウナ一覧')

<!-- header.blade.php の読み込み -->
@include('layouts.admin.header')

<!-- sidebar.blade.php の読み込み -->
@include('layouts.admin.sidebar')

<!-- 'contents'という名称で他のBladeからの呼び出しを可能にする -->
@section('contents')
<h2>コンテンツ登録</h2>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/admin/content') }}" class="btn btn-secondary">一覧へ戻る</a>
    </div>
    <form action="{{ $content->id ? url('/admin/content/edit/'.$content->id) : url('/admin/content/add') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @include('admin.content._form')

        <div class="mt-4 form-group form-btn-group">
            <input class="tbl-btn edit c-btn--primary" type="submit" name="send" value="登録">
        </div>
    </form>
</div>
@if (isset($message))
<p>{{ $message }}</p>
@endif
@endsection
