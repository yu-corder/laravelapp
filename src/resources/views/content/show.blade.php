@extends('layouts.sauna.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'サウナ一覧')

@include('layouts.sauna.header')

@include('layouts.sauna.sidebar')

@section('contents')
<div class="ck-content">
    {!! $content->body !!}
</div>
@endsection
