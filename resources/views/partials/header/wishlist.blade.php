@auth
    @php
        $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
    @endphp
@else
    @php $wishlistCount = 0; @endphp
@endauth
<div class="wishlist">
    <a href="#" title="Wishlist">
        <div class="icon">
            <i class="icon-heart-o"></i>
            <span class="wishlist-count badge">@if($wishlistCount > 0){{ $wishlistCount }}@endif</span>
        </div>
        <p>Wishlist</p>
    </a>
</div>