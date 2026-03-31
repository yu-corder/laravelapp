<!-- 'sidebar'という名称で他のBladeからの呼び出しを可能にする -->
@section('sidebar')
<div class="sidebar">
    <h2>管理メニュー</h2>
    <ul class="menu-list">
        <li><a href="{{ url('admin/sauna') }}">サウナ一覧</a></li>
        <li><a href="{{ url('admin/sauna/add') }}">サウナ登録</a></li>
        <li><a href="{{ url('admin/totonoi-history') }}">サ活管理</a></li>
        <li><a href="{{ url('admin/contents') }}">コンテンツ管理</a></li>
        <li><a href="{{ url('saunas/') }}">一般画面</a></li>
    </ul>
</div>
@endsection
