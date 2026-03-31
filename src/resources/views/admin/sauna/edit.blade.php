@extends('layouts.admin.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'サウナ一覧')

@include('layouts.admin.header')

@include('layouts.admin.sidebar')

@section('contents')
<h2>サウナ編集</h2>
<form action="{{ url('admin/sauna/edit/'.$sauna->id) }}" method="post">
    @csrf
    @method('PATCH')
    @include('admin.sauna._form', ['sauna' => $sauna])
    <div class="form-group form-btn-group">
        <input class="tbl-btn edit c-btn--primary" type="submit" name="send" value="更新">
    </div>
</form>
@if (isset($message))
<p>{{ $message }}</p>
@endif
@endsection
