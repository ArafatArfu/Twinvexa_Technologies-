@php
$mainMenuItems = $headerSections->where('key', 'main_menu')->first()?->menus->whereNull('parent_id') ?? collect();
@endphp

<div class="tab-content">
    <div class="tab-pane fade show active" id="mobile-menu-tab" role="tabpanel" aria-labelledby="mobile-menu-link">
        <nav class="mobile-nav">
            <ul class="mobile-menu">
                @foreach($mainMenuItems as $item)
                    <li class="{{ $item->children->count() > 0 ? 'active' : '' }}">
                        <a href="{{ $item->url }}">{{ $item->title }}</a>
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
                @endforeach
            </ul>
        </nav>
    </div>

    @include('partials.mobile-menu.categories-nav')
</div>