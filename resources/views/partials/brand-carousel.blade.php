@php
$brands = ['1.png', '2.png', '3.png', '4.png', '5.png', '6.png'];
@endphp

<div class="container">
    <div class="owl-carousel mt-5 mb-5 owl-simple" data-toggle="owl"
        data-owl-options='{
            "nav": false,
            "dots": false,
            "margin": 30,
            "loop": false,
            "responsive": {
                "0": {"items":2},
                "420": {"items":3},
                "600": {"items":4},
                "900": {"items":5},
                "1024": {"items":6}
            }
        }'>
        @foreach($brands as $brand)
            <a href="#" class="brand"><img src="{{ asset('assets/images/brands/' . $brand) }}" alt="Brand Name"></a>
        @endforeach
    </div>
</div>