@extends('layouts.sauna.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'サウナ一覧')

@include('layouts.sauna.header')

@include('layouts.sauna.sidebar')

@section('contents')
<div>
    <img class="sauna_first_image" src="{{ Storage::url($saunaImage->file_path) }}" alt="＊サウナイメージ画像">
</div>
<div class="ck-content">
    {!! $content->body !!}
</div>
@endsection
