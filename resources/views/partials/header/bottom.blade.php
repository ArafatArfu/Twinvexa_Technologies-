@php
use Illuminate\Support\Facades\Auth;
@endphp

<div class="header-bottom sticky-header">
    <div class="container">
        <div class="header-left">
            @include('partials.header.category-dropdown')
        </div>

        <div class="header-center">
            @include('partials.header.main-nav')
        </div>

        <div class="header-right">
            @if($settings)
                <i class="la la-lightbulb-o"></i>
                <p>{{ $settings->top_bar_text ?? 'Clearance' }}<span class="highlight">&nbsp;{{ $settings->top_bar_highlight ?? 'Up to 30% Off' }}</span></p>
            @else
                <i class="la la-lightbulb-o"></i>
                <p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>
            @endif
        </div>
    </div>
</div>