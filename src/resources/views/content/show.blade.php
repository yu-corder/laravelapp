@extends('layouts.sauna.main')

@section('title', 'サウナ一覧')

@section('contents')
<div>
    <img class="sauna_first_image" src="{{ Storage::url($saunaImage->file_path) }}" alt="＊サウナイメージ画像">
</div>
<div class="ck-content">
    {!! $content->body !!}
</div>
@endsection
