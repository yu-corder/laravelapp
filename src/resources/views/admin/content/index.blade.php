@extends('layouts.admin.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'コンテンツ一覧')

@include('layouts.admin.header')

@include('layouts.admin.sidebar')

@section('contents')
<h2>コンテンツ一覧</h2>
<div class="container">
    <div class="mb-4">
        <a href="{{ url('/admin/content/add') }}" class="btn btn-secondary" style="text-decoration:none;">新規登録</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="tbl">
        <thead>
            <tr>
                <th>ID</th>
                <th>タイプ</th>
                <th>対象施設</th>
                <th>タイトル</th>
                <th>公開状況</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contents as $content)
            <tr>
                <td>{{ $content->id }}</td>
                <td>
                    {{ $content->type === 'facility' ? '施設紹介' : ($content->type === 'column' ? 'コラム' : 'お知らせ') }}
                </td>
                <td>{{ $content->sauna->name ?? '-' }}</td>
                <td>{{ $content->title }}</td>
                <td>
                    <span class="{{ $content->is_public ? 'text-success' : 'text-muted' }}">
                        {{ $content->is_public ? '公開中' : '非公開' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <form action="{{ url('/admin/content/edit/'.$content->id) }}" method="get">
                            <input class="tbl-btn edit" type="submit" value="編集">
                        </form>
                        <form class="content-delete" action="{{ url('/admin/content/delete/'.$content->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            <input class="tbl-btn delete" type="submit" value="削除">
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
