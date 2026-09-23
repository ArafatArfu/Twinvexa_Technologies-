<div class="header-top">
    <div class="container">
        <div class="header-left">
            <a href="tel:#">
                <i class="{{ $settings->contact_icon ?? 'icon-phone' }}"></i>
                Call: +01621643664
            </a>
        </div>

        <div class="header-right">
            <ul class="top-menu">
                <li>
                    <a href="javascript:void(0)">Links</a>
                    <ul>
                        <li>
                            <div class="header-dropdown">
                                <a href="javascript:void(0)">USD</a>
                                @include('partials.header.currency-dropdown')
                            </div>
                        </li>
                        <li>
                            <div class="header-dropdown">
                                <a href="javascript:void(0)">English</a>
                                @include('partials.header.language-dropdown')
                            </div>
                        </li>
                        @auth
                            <li>
                                <div class="header-dropdown">
                                    <a href="javascript:void(0)"><i class="icon-user"></i> {{ Auth::user()->name }}</a>
                                    <div class="header-menu">
                                        <ul>
                                            <li><a href="{{ route('admin.header.index') }}">Admin</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link" style="padding: 0.5rem 1rem;">Logout</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}"><i class="icon-user"></i> Login</a></li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>