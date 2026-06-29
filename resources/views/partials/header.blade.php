<header class="header header-intro-clearance {{ $settings->sticky_class ?? 'header-4' }}">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <a href="tel:#"><i class="icon-phone"></i>Call: +0123 456 789</a>
            </div>

            <div class="header-right">
                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <li>
                                <div class="header-dropdown">
                                    <a href="#">USD</a>
                                    @include('partials.header.currency-dropdown')
                                </div>
                            </li>
                            <li>
                                <div class="header-dropdown">
                                    <a href="#">English</a>
                                    @include('partials.header.language-dropdown')
                                </div>
                            </li>
                            <li><a href="#signin-modal" data-toggle="modal">Sign in / Sign up</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @include('partials.header.middle')

    @include('partials.header.bottom')
</header>