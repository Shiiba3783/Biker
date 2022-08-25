
    <div class = "container">
        <nav class = "navbar navbar-light header_nav">
            <h1 class = "header_logo mx-auto">
                <a href = "/posts" class = "navbar-brand">BIKER</a>
            </h1>
            @if( Auth::check() )
                <div>
                    <ul class = "navbar-nav flex-row">
                        <li class = "nav-item px-3">
                            <a href = "{{ route('users.show',\Auth::user()) }}" class = "nav-link">{{ \Auth::user()->name }}</a>
                        </li>
                        <li class = "nav-item px-3">
                            <form action="{{ route('logout') }}" method="POST" class = "nav-link">
                                @csrf
                                <input type="submit" value="ログアウト">
                            </form>
                        </li>
                    </ul>
                </div>
                
            @else
                <div>
                    <ul class = "navbar-nav flex-row">
                        <li class = "nav-item px-3">
                            <a href="{{ route('login') }}">ログイン</a>
                        </li>
                        <li class = "nav-item px-3">
                            <a href="{{ route('register') }}">新規会員登録 </a>
                        </li>
                    </ul>
                </div>
            @endif
        </nav>
    </div>
