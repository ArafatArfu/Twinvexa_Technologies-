@php
$mainMenuItems = $headerSections->where('key', 'main_menu')->first()?->menus->whereNull('parent_id') ?? collect();
@endphp

<nav class="main-nav">
    <ul class="menu sf-arrows">
        @foreach($mainMenuItems as $item)
            @if($item->is_megamenu)
                @include('partials.header.menu-'.$item->megamenu_class, ['item' => $item])
            @else
                <li class="{{ $item->children->count() > 0 ? 'megamenu-container active' : '' }}">
                    <a href="{{ $item->url }}" class="{{ $item->children->count() > 0 ? 'sf-with-ul' : '' }}">{{ $item->title }}</a>

                    @if($item->children->count() > 0)
                        <ul>
                            @foreach($item->children as $child)
                                <li>
                                    @if($child->children->count() > 0)
                                        <a href="{{ $child->url }}" class="sf-with-ul">{{ $child->title }}</a>
                                    @else
                                        <a href="{{ $child->url }}">{{ $child->title }}</a>
                                    @endif
                                    @if($child->children->count() > 0)
                                        <ul>
                                            @foreach($child->children as $grandchild)
                                                <li><a href="{{ $grandchild->url }}">{{ $grandchild->title }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
</nav>