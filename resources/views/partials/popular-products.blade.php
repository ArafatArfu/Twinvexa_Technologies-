@php
    $popularProducts = \App\Models\Product::active()
        ->where('is_popular', true)
        ->with(['category', 'brand', 'images'])
        ->orderByDesc('display_order')
        ->orderByDesc('created_at')
        ->limit(10)
        ->get();
@endphp

@if($popularProducts->isNotEmpty())
<section class="popular-products-section py-4">
    <div class="container-fluid px-4">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <span class="popular-products-icon">
                    <span class="popular-products-fire">&#128293;</span>
                </span>

                <h2 class="popular-products-title mb-0">
                    Popular Products
                </h2>

                <span class="popular-products-subtitle">
                    Trending choices from our customers
                </span>
            </div>

            <div class="popular-products-arrows">
                <button type="button"
                        class="popular-products-prev"
                        aria-label="Previous products">
                    <i class="icon-angle-left"></i>
                </button>

                <button type="button"
                        class="popular-products-next"
                        aria-label="Next products">
                    <i class="icon-angle-right"></i>
                </button>
            </div>
        </div>

        <div class="owl-carousel popular-products-carousel">
            @foreach($popularProducts as $product)
                @php
                    $productImage = $product->image
                        ? (
                            \Illuminate\Support\Str::startsWith(
                                $product->image,
                                ['http://', 'https://']
                            )
                                ? $product->image
                                : asset('storage/' . ltrim($product->image, '/'))
                        )
                        : asset('assets/images/products/product-15.jpg');

                    $productUrl = route('products.show', $product->slug);
                    $brandName = $product->brand->name
                        ?? $product->category->name
                        ?? 'POPULAR';
                @endphp

                <div class="popular-product-card">
                    <div class="popular-product-image-box">

                        <a href="{{ $productUrl }}">
                            <img src="{{ $productImage }}"
                                 alt="{{ $product->name }}"
                                 class="popular-product-image">
                        </a>
                    </div>

                    <div class="popular-product-card-body">
                        <div class="popular-product-brand">
                            {{ strtoupper($brandName) }}
                        </div>

                        <a href="{{ $productUrl }}"
                           class="popular-product-name">
                            {{ $product->name }}
                        </a>

                        <div class="popular-product-price">
                            &#2547;{{ number_format((float) $product->price, 0) }}
                        </div>

                        <a href="{{ $productUrl }}"
                           class="popular-product-view-button">
                            View Product
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('styles')
<style>
.popular-products-section {
    background: #f3f5f9;
}

.popular-products-title {
    color: #063b5d;
    font-size: 30px;
    font-weight: 700;
}

.popular-products-subtitle {
    color: #9aa8bd;
    font-size: 20px;
    letter-spacing: 1px;
}

.popular-products-icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: #ddf6ed;
    color: #00a879;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

.popular-products-arrows {
    display: flex;
    gap: 12px;
}

.popular-products-arrows button {
    width: 52px;
    height: 52px;
    border: 1px solid #dce2eb;
    border-radius: 50%;
    background: #fff;
    color: #617087;
    font-size: 24px;
}

.popular-product-card {
    background: #fff;
    border: 1px solid #dfe4ec;
    border-radius: 14px;
    overflow: hidden;
    min-height: 600px;
    margin: 0 10px;
    display: flex;
    flex-direction: column;
}

.popular-product-image-box {
    height: 260px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 25px;
    background: #fff;
}

.popular-product-image {
    width: 100%;
    height: 220px;
    object-fit: contain;
}



.popular-product-card-body {
    padding: 18px 22px 22px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.popular-product-brand {
    color: #9aa8bd;
    font-size: 15px;
    letter-spacing: 2px;
    margin-bottom: 12px;
}

.popular-product-name {
    color: #202532;
    font-size: 20px;
    line-height: 1.35;
    font-weight: 600;
    min-height: 82px;
}

.popular-product-price {
    color: #171b25;
    font-size: 26px;
    font-weight: 700;
    margin-top: 12px;
    margin-bottom: auto;
}

.popular-product-view-button {
    background: #f1f3f8;
    border: 1px solid #dfe4ec;
    border-radius: 13px;
    color: #202532;
    text-align: center;
    font-size: 18px;
    font-weight: 600;
    padding: 15px 10px;
    margin-top: 25px;
}

.popular-product-view-button:hover {
    background: #e5e9f1;
    color: #111827;
}

@media (max-width: 767px) {
    .popular-products-title {
        font-size: 23px;
    }

    .popular-products-subtitle {
        display: none;
    }

    .popular-product-card {
        min-height: 520px;
    }

    .popular-product-image-box {
        height: 220px;
    }

    .popular-product-image {
        height: 180px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var carousel = $('.popular-products-carousel');

    carousel.owlCarousel({
        loop: false,
        margin: 12,
        nav: false,
        dots: false,
        responsive: {
            0: { items: 1.2 },
            576: { items: 2 },
            768: { items: 3 },
            992: { items: 4 },
            1200: { items: 5 }
        }
    });

    $('.popular-products-prev').on('click', function () {
        carousel.trigger('prev.owl.carousel');
    });

    $('.popular-products-next').on('click', function () {
        carousel.trigger('next.owl.carousel');
    });
});
</script>
@endpush

@push('styles')
<style>
.popular-products-section {
    background: linear-gradient(135deg, #f4f8ff 0%, #eefbf7 100%);
    padding-top: 42px !important;
    padding-bottom: 48px !important;
}

.popular-products-title {
    color: #082f49;
    font-size: 31px;
    font-weight: 800;
    letter-spacing: -.5px;
}

.popular-products-subtitle {
    color: #718096;
    font-size: 17px;
    font-weight: 500;
}

.popular-products-icon {
    width: 58px;
    height: 58px;
    border-radius: 18px;
    background: linear-gradient(135deg, #d8fff0, #b9f3df);
    color: #079669;
    box-shadow: 0 8px 22px rgba(0, 160, 120, .15);
}

.popular-products-arrows button {
    width: 50px;
    height: 50px;
    border: 0;
    border-radius: 50%;
    background: #fff;
    color: #134e6f;
    box-shadow: 0 6px 18px rgba(15, 45, 75, .12);
    transition: .25s ease;
}

.popular-products-arrows button:hover {
    color: #fff;
    background: linear-gradient(135deg, #0ea5e9, #2563eb);
    transform: translateY(-2px);
}

.popular-product-card {
    position: relative;
    background: #fff;
    border: 1px solid rgba(148, 163, 184, .22);
    border-radius: 22px;
    overflow: hidden;
    min-height: 610px;
    margin: 0 9px;
    box-shadow: 0 10px 30px rgba(30, 64, 95, .10);
    transition: transform .3s ease, box-shadow .3s ease;
}

.popular-product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 38px rgba(30, 64, 95, .18);
}

.popular-product-image-box {
    height: 275px;
    padding: 28px;
    background:
        radial-gradient(circle at 50% 30%, rgba(219, 244, 255, .95), transparent 48%),
        linear-gradient(145deg, #ffffff, #f1f7fc);
}

.popular-product-image {
    height: 225px;
    transition: transform .35s ease;
}

.popular-product-card:hover .popular-product-image {
    transform: scale(1.07);
}



.popular-product-card-body {
    padding: 22px 23px 23px;
}

.popular-product-brand {
    color: #0ea5a4;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.popular-product-name {
    color: #172033;
    font-size: 18px;
    line-height: 1.4;
    font-weight: 700;
    transition: color .2s ease;
}

.popular-product-name:hover {
    color: #2563eb;
}

.popular-product-price {
    color: #e11d48;
    font-size: 27px;
    font-weight: 800;
    letter-spacing: -.5px;
    margin-top: 15px;
}

.popular-product-view-button {
    border: 0;
    border-radius: 12px;
    background: linear-gradient(135deg, #2563eb, #06b6d4);
    color: #fff;
    box-shadow: 0 8px 18px rgba(37, 99, 235, .22);
    font-size: 16px;
    font-weight: 700;
    padding: 14px 10px;
    transition: .25s ease;
}

.popular-product-view-button:hover {
    color: #fff;
    background: linear-gradient(135deg, #1d4ed8, #0891b2);
    transform: translateY(-2px);
}

@media (max-width: 767px) {
    .popular-products-section {
        padding-top: 28px !important;
    }

    .popular-products-title {
        font-size: 23px;
    }

    .popular-products-subtitle {
        display: none;
    }

    .popular-product-card {
        min-height: 535px;
        border-radius: 18px;
    }

    .popular-product-image-box {
        height: 225px;
    }

    .popular-product-image {
        height: 180px;
    }
}
</style>
@endpush


@push('styles')
<style>
/* FINAL COLORFUL CARD OVERRIDE */

.popular-product-card {
    position: relative;
    background: linear-gradient(145deg, #ffffff 0%, #f8fbff 100%);
    border: 2px solid transparent;
    border-radius: 22px;
    background:
        linear-gradient(145deg, #ffffff, #f8fbff) padding-box,
        linear-gradient(135deg, #06b6d4, #6366f1, #ec4899, #f97316) border-box;
    box-shadow:
        0 8px 20px rgba(37, 99, 235, .10),
        0 2px 5px rgba(15, 23, 42, .06);
    overflow: hidden;
    transition:
        transform .35s ease,
        box-shadow .35s ease,
        border-radius .35s ease;
}

.popular-product-card::before {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    opacity: .18;
    background:
        radial-gradient(circle at 10% 0%, #22d3ee 0, transparent 28%),
        radial-gradient(circle at 100% 100%, #f472b6 0, transparent 30%);
}

.popular-product-card:hover {
    transform: translateY(-10px) scale(1.015);
    border-radius: 25px;
    box-shadow:
        0 22px 45px rgba(37, 99, 235, .20),
        0 8px 18px rgba(236, 72, 153, .12);
}

.popular-product-image-box {
    position: relative;
    z-index: 1;
    height: 275px;
    padding: 28px;
    background:
        radial-gradient(circle at 50% 30%, rgba(186, 230, 253, .9), transparent 42%),
        linear-gradient(145deg, #ffffff 0%, #eff6ff 55%, #fdf2f8 100%);
    border-bottom: 1px solid rgba(99, 102, 241, .12);
}

.popular-product-image {
    height: 225px;
    object-fit: contain;
    transition: transform .4s ease, filter .4s ease;
}

.popular-product-card:hover .popular-product-image {
    transform: scale(1.09) rotate(-1deg);
    filter: drop-shadow(0 14px 16px rgba(37, 99, 235, .20));
}

.popular-product-card-body {
    position: relative;
    z-index: 1;
    padding: 22px 23px 23px;
    background: linear-gradient(180deg, rgba(255,255,255,.96), #ffffff);
}

.popular-product-brand {
    color: #0891b2;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.popular-product-name {
    color: #172033;
    font-size: 18px;
    line-height: 1.4;
    font-weight: 700;
    transition: color .25s ease;
}

.popular-product-card:hover .popular-product-name {
    color: #4f46e5;
}

.popular-product-price {
    color: #e11d48;
    font-size: 27px;
    font-weight: 800;
    margin-top: 15px;
}

.popular-product-view-button {
    border: 0;
    border-radius: 13px;
    background: linear-gradient(135deg, #2563eb, #7c3aed, #db2777);
    background-size: 200% 200%;
    color: #fff;
    box-shadow: 0 8px 18px rgba(124, 58, 237, .25);
    font-size: 16px;
    font-weight: 700;
    padding: 14px 10px;
    transition: background-position .35s ease, transform .25s ease, box-shadow .25s ease;
}

.popular-product-view-button:hover {
    color: #fff;
    background-position: 100% 50%;
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(219, 39, 119, .30);
}

@media (max-width: 767px) {
    .popular-product-card {
        border-radius: 18px;
    }

    .popular-product-image-box {
        height: 225px;
    }

    .popular-product-image {
        height: 180px;
    }
}
</style>
@endpush


@push('styles')
<style>
/* FINAL POPULAR HEADING AND BORDER DESIGN */

.popular-products-section {
    background:
        radial-gradient(circle at 5% 10%, rgba(45, 212, 191, .12), transparent 25%),
        radial-gradient(circle at 95% 90%, rgba(236, 72, 153, .10), transparent 25%),
        #f5f8fc;
}

.popular-products-icon {
    width: 64px;
    height: 64px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
    background: linear-gradient(135deg, #fff7ed, #fed7aa);
    border: 2px solid #fb923c;
    box-shadow:
        0 8px 20px rgba(249, 115, 22, .22),
        inset 0 0 0 5px rgba(255,255,255,.55);
}

.popular-products-fire {
    font-size: 34px;
    line-height: 1;
    filter: drop-shadow(0 4px 5px rgba(234, 88, 12, .25));
}

.popular-products-title {
    position: relative;
    display: inline-block;
    color: #082f49;
    font-size: 32px;
    font-weight: 800;
    letter-spacing: -.7px;
    margin: 0;
}

.popular-products-title::after {
    content: "";
    display: block;
    width: 72%;
    height: 4px;
    border-radius: 10px;
    margin-top: 7px;
    background: linear-gradient(90deg, #f97316, #ec4899, #6366f1);
}

.popular-products-subtitle {
    color: #64748b;
    font-size: 17px;
    font-weight: 600;
    letter-spacing: .2px;
}

/* Clearly visible colorful card borders */
.popular-product-card {
    border: 3px solid #38bdf8 !important;
    border-radius: 22px !important;
    background: #ffffff !important;
    box-shadow:
        0 10px 24px rgba(30, 64, 175, .10),
        inset 0 0 0 1px rgba(255,255,255,.85);
    transition:
        transform .35s ease,
        box-shadow .35s ease,
        border-color .35s ease;
}

.popular-product-card:nth-child(2n) {
    border-color: #a78bfa !important;
}

.popular-product-card:nth-child(3n) {
    border-color: #fb7185 !important;
}

.popular-product-card:nth-child(4n) {
    border-color: #34d399 !important;
}

.popular-product-card:nth-child(5n) {
    border-color: #fbbf24 !important;
}

.popular-product-card:hover {
    transform: translateY(-10px) scale(1.015);
    border-color: #2563eb !important;
    box-shadow:
        0 22px 42px rgba(37, 99, 235, .22),
        0 0 0 4px rgba(96, 165, 250, .14);
}

.popular-product-image-box {
    border-radius: 18px 18px 0 0;
    background:
        radial-gradient(circle at 50% 20%, rgba(186, 230, 253, .9), transparent 43%),
        linear-gradient(145deg, #ffffff, #eff6ff 60%, #fdf2f8);
}

.popular-product-card-body {
    background: linear-gradient(180deg, #ffffff, #f8fbff);
}

@media (max-width: 767px) {
    .popular-products-title {
        font-size: 24px;
    }

    .popular-products-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
    }

    .popular-products-fire {
        font-size: 28px;
    }

    .popular-products-subtitle {
        display: none;
    }

    .popular-product-card {
        border-width: 2px !important;
        border-radius: 18px !important;
    }
}
</style>
@endpush


@push('styles')
<style>
/* FINAL POPULAR CARD VISUAL FIX */

.popular-products-section {
    padding-left: 8px;
    padding-right: 8px;
    overflow: hidden;
}

.popular-products-icon {
    width: 72px !important;
    height: 72px !important;
    min-width: 72px;
    border-radius: 22px !important;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #fff7ed, #fed7aa) !important;
    border: 2px solid #fb923c !important;
    box-shadow:
        0 10px 24px rgba(249, 115, 22, .25),
        inset 0 0 0 5px rgba(255,255,255,.65);
}

.popular-products-fire {
    display: inline-block;
    font-size: 46px !important;
    line-height: 1;
    transform: translateY(-1px);
    filter: drop-shadow(0 5px 5px rgba(234, 88, 12, .25));
}

.popular-products-title {
    color: #082f49 !important;
    font-size: 32px !important;
    font-weight: 800 !important;
    letter-spacing: -.7px;
}

.popular-products-subtitle {
    color: #0891b2 !important;
    font-size: 18px !important;
    font-weight: 700 !important;
    letter-spacing: .2px;
    background: linear-gradient(90deg, #0891b2, #7c3aed, #db2777);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Space between cards */
.popular-products-carousel {
    margin-left: -8px;
    margin-right: -8px;
}

.popular-products-carousel .owl-stage {
    padding: 10px 0 18px;
}

.popular-products-carousel .owl-item {
    padding: 0 9px;
}

/* Clearly visible border around every card */
.popular-product-card {
    width: calc(100% - 2px);
    margin: 0 auto !important;
    border: 3px solid #38bdf8 !important;
    outline: 1px solid rgba(255,255,255,.9);
    border-radius: 22px !important;
    background: #fff !important;
    box-shadow:
        0 8px 20px rgba(30, 64, 175, .14),
        0 0 0 2px rgba(56, 189, 248, .08);
    transition:
        transform .35s ease,
        box-shadow .35s ease,
        border-color .35s ease;
}

.popular-product-card:nth-child(2n) {
    border-color: #8b5cf6 !important;
}

.popular-product-card:nth-child(3n) {
    border-color: #ec4899 !important;
}

.popular-product-card:nth-child(4n) {
    border-color: #10b981 !important;
}

.popular-product-card:nth-child(5n) {
    border-color: #f59e0b !important;
}

/* Strong hover effect */
.popular-product-card:hover {
    transform: translateY(-12px) scale(1.025);
    border-color: #2563eb !important;
    box-shadow:
        0 24px 48px rgba(37, 99, 235, .28),
        0 0 0 5px rgba(96, 165, 250, .20);
    z-index: 10;
}

.popular-product-card:hover .popular-product-image {
    transform: scale(1.10);
    filter: drop-shadow(0 14px 16px rgba(37, 99, 235, .25));
}

.popular-product-image {
    transition: transform .4s ease, filter .4s ease;
}

.popular-product-name {
    transition: color .25s ease;
}

.popular-product-card:hover .popular-product-name {
    color: #4f46e5 !important;
}

.popular-product-view-button {
    transition:
        transform .25s ease,
        box-shadow .25s ease,
        background-position .35s ease;
}

.popular-product-view-button:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 12px 25px rgba(219, 39, 119, .32) !important;
}

@media (max-width: 767px) {
    .popular-products-icon {
        width: 58px !important;
        height: 58px !important;
        min-width: 58px;
    }

    .popular-products-fire {
        font-size: 37px !important;
    }

    .popular-products-title {
        font-size: 24px !important;
    }

    .popular-products-subtitle {
        display: none;
    }

    .popular-products-carousel .owl-item {
        padding: 0 6px;
    }

    .popular-product-card {
        border-width: 2px !important;
        border-radius: 18px !important;
    }
}
</style>
@endpush

@push('styles')
<style>
.popular-products-carousel .owl-item {
    padding: 10px 12px 22px;
}

.popular-product-card {
    display: flex;
    flex-direction: column;
    min-height: 590px;
    overflow: hidden;
    background: #fff;
    border: 2px solid #dbeafe !important;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(15,23,42,.10);
    transition: .3s ease;
}

.popular-product-card:hover {
    transform: translateY(-9px) scale(1.015);
    border-color: #2563eb !important;
    box-shadow: 0 20px 42px rgba(37,99,235,.25);
}

.popular-product-image-box {
    height: 270px;
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(145deg,#f8fbff,#eef4ff);
}

.popular-product-image {
    width: 100%;
    height: 220px;
    object-fit: contain;
    transition: transform .35s ease;
}

.popular-product-card:hover .popular-product-image {
    transform: scale(1.08);
}

.popular-product-card-body {
    display: flex;
    flex: 1;
    flex-direction: column;
    padding: 22px;
}

.popular-product-brand {
    margin-bottom: 10px;
    color: #0891b2;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.8px;
    text-transform: uppercase;
}

.popular-product-name {
    min-height: 76px;
    color: #172033;
    font-size: 18px;
    font-weight: 700;
    line-height: 1.4;
    text-decoration: none;
}

.popular-product-name:hover {
    color: #2563eb;
}

.popular-product-price {
    margin-top: 18px;
    margin-bottom: auto;
    color: #2563eb;
    font-size: 27px;
    font-weight: 800;
}

.popular-product-view-button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    margin-top: 24px;
    padding: 14px 18px;
    border-radius: 12px;
    background: linear-gradient(135deg,#2563eb,#7c3aed);
    color: #fff !important;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 8px 16px rgba(37,99,235,.25);
    transition: .25s ease;
}

.popular-product-view-button:hover {
    background: linear-gradient(135deg,#1d4ed8,#db2777);
    color: #fff !important;
    transform: translateY(-3px);
    box-shadow: 0 13px 25px rgba(219,39,119,.30);
}

@media (max-width:767px) {
    .popular-product-card {
        min-height: 520px;
        border-radius: 16px;
    }

    .popular-product-image-box {
        height: 220px;
    }

    .popular-product-image {
        height: 175px;
    }
}
</style>
@endpush
