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
<h2>コンテンツ編集</h2>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 contents-back">
        <a href="{{ url('/admin/contents') }}" class="btn btn-secondary">一覧へ戻る</a>
    </div>

    <form action="{{ url('/admin/content/edit/'.$content->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        {{-- 共通フォームを読み込み。$content に値が入っているので自動で埋まります --}}
        @include('admin.content._form')

        <div class="mt-4 form-group form-btn-group">
            <input class="tbl-btn edit c-btn--primary" type="submit" name="send" value="更新">
        </div>
    </form>
</div>
@endsection
