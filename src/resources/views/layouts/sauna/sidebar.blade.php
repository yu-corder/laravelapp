<!-- 'sidebar'という名称で他のBladeからの呼び出しを可能にする -->
@section('sidebar')
<div class="sidebar">
    <h2>メニュー</h2>
    <ul class="menu-list">
        <li><a href="{{ url('saunas/') }}">総合ランキング</a></li>
    </ul>
</div>
@endsection
