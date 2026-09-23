<div class="col-sm-6 col-lg-3">
    <div class="widget">
        <h4 class="widget-title">Customer Service</h4>

        <ul class="widget-list">
            @if(isset($footerLinks))
                @foreach($footerLinks->get('customer_service', []) as $link)
                    <li><a href="{{ $link->url ?: '#' }}">{{ $link->title }}</a></li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
