@extends('layouts.admin.main')

<!-- main.blade.php @yield('title')への値受け渡し -->
@section('title', 'サウナ一覧')

@include('layouts.admin.header')

@include('layouts.admin.sidebar')

@section('contents')

<h2>サウナ一覧</h2>
    <table class="tbl">
        <thead>
            <tr>
                <th>サウナ名</th>
                <th>住所</th>
                <th>サウナ温度</th>
                <th>水風呂温度</th>
                <th>ロウリュウ</th>
                <th><!-- 編集ボタン --></th>
                <th><!-- 削除ボタン --></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($saunas as $key => $sauna)
                <tr>
                    <td>{{ $sauna->name }}</td>
                    <td>{{ $sauna->prefecture }}</td>
                    <td>{{ $sauna->sauna_temp }}</td>
                    <td>{{ $sauna->water_temp }}</td>
                    <td>{{ $sauna->has_loyly ? '有り' : '無し' }}</td>
                    <td class="action">
                        <form action="{{ url('admin/sauna/edit/'. $sauna->id) }}" method="get">
                            <input class="tbl-btn edit" type="submit" value="編集">
                        </form>
                        <form action="{{ url('admin/sauna/delete/'. $sauna->id) }}" method="post">
                            @csrf
                            <input class="tbl-btn delete" type="submit" value="削除">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
