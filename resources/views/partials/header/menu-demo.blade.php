@php
$demos = [
    ['image' => '1.jpg', 'title' => '01 - furniture store'],
    ['image' => '2.jpg', 'title' => '02 - furniture store'],
    ['image' => '3.jpg', 'title' => '03 - electronic store'],
    ['image' => '4.jpg', 'title' => '04 - electronic store'],
    ['image' => '5.jpg', 'title' => '05 - fashion store'],
    ['image' => '6.jpg', 'title' => '06 - fashion store'],
    ['image' => '7.jpg', 'title' => '07 - fashion store'],
    ['image' => '8.jpg', 'title' => '08 - fashion store'],
    ['image' => '9.jpg', 'title' => '09 - fashion store'],
    ['image' => '10.jpg', 'title' => '10 - shoes store'],
    ['image' => '11.jpg', 'title' => '11 - furniture simple store', 'hidden' => true],
    ['image' => '12.jpg', 'title' => '12 - fashion simple store', 'hidden' => true],
    ['image' => '13.jpg', 'title' => '13 - market', 'hidden' => true],
    ['image' => '14.jpg', 'title' => '14 - market fullwidth', 'hidden' => true],
    ['image' => '15.jpg', 'title' => '15 - lookbook 1', 'hidden' => true],
    ['image' => '16.jpg', 'title' => '16 - lookbook 2', 'hidden' => true],
    ['image' => '17.jpg', 'title' => '17 - fashion store', 'hidden' => true],
    ['image' => '18.jpg', 'title' => '18 - fashion store (with sidebar)', 'hidden' => true],
    ['image' => '19.jpg', 'title' => '19 - games store', 'hidden' => true],
    ['image' => '20.jpg', 'title' => '20 - book store', 'hidden' => true],
    ['image' => '21.jpg', 'title' => '21 - sport store', 'hidden' => true],
    ['image' => '22.jpg', 'title' => '22 - tools store', 'hidden' => true],
    ['image' => '23.jpg', 'title' => '23 - fashion left navigation store', 'hidden' => true],
    ['image' => '24.jpg', 'title' => '24 - extreme sport store', 'hidden' => true],
];
@endphp

<div class="megamenu demo">
    <div class="menu-col">
        <div class="menu-title">Choose your demo</div>

        <div class="demo-list">
            @foreach($demos as $demo)
                <div class="demo-item @if($demo['hidden'] ?? false) hidden @endif">
                    <a href="#">
                        <span class="demo-bg" style="background-image: url({{ asset('assets/images/menu/demos/' . $demo['image']) }});"></span>
                        <span class="demo-title">{{ $demo['title'] }}</span>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="megamenu-action text-center">
            <a href="#" class="btn btn-outline-primary-2 view-all-demos"><span>View All Demos</span><i class="icon-long-arrow-right"></i></a>
        </div>
    </div>
</div>