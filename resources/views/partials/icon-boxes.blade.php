@php
$features = [
    ['icon' => 'icon-rocket', 'title' => 'Free Shipping', 'desc' => 'Orders $50 or more'],
    ['icon' => 'icon-rotate-left', 'title' => 'Free Returns', 'desc' => 'Within 30 days'],
    ['icon' => 'icon-info-circle', 'title' => 'Get 20% Off 1 Item', 'desc' => 'when you sign up'],
    ['icon' => 'icon-life-ring', 'title' => 'We Support', 'desc' => '24/7 amazing services'],
];
@endphp

<div class="icon-boxes-container bg-transparent">
    <div class="container">
        <div class="row">
            @foreach($features as $feature)
                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="{{ $feature['icon'] }}"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">{{ $feature['title'] }}</h3>
                            <p>{{ $feature['desc'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>