@extends('layouts.admin.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'サウナ一覧')

@include('layouts.admin.header')

@include('layouts.admin.sidebar')

@section('contents')
<h2>コンテンツ登録</h2>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 contents-back">
        <a href="{{ url('/admin/contents') }}" class="btn btn-secondary">一覧へ戻る</a>
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
