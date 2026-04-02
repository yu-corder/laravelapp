@section('header')
<header class="header">
    <div class="header-inner">
        <div class="logo">
            <a href="{{ url('admin/sauna') }}">
                <img class="sauna-rally-logo" src="{{ asset('images/icons/sauna_rally_log3.png') }}" alt="Sauna_rally!">
            </a>
        </div>
        <nav class="login-user">
            <a href="{{ url('profile') }}">
                <li>{{ Auth::user()->name }}</li>
            </a>
            <form action="{{ url('logout') }}" method="post">
                @csrf
                <input
                    class="link-style-btn"
                    type="submit"
                    name="logout"
                    value="ログアウト"
                />
            </form>
        </nav>
    </div>
</header>
@endsection
