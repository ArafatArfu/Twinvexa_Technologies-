<nav class="main-nav">
    <ul class="menu sf-arrows">
        @foreach($navbarItems as $item)
            <li class="{{ $item->children->count() > 0 ? 'megamenu-container' : '' }} {{ $item->is_dropdown ? 'megamenu-container' : '' }}">
                <a href="{{ $item->url }}" class="{{ $item->children->count() > 0 ? 'sf-with-ul' : '' }}">{{ $item->title }}</a>

                @if($item->children->count() > 0)
                    <div class="megamenu demo">
                        <div class="menu-col">
                            <div class="menu-title">Submenu</div>
                            <ul>
                                @foreach($item->children as $child)
                                    <li><a href="{{ $child->url }}">{{ $child->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</nav>