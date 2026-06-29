@php
$categories = [
    ['image' => 'assets/images/demos/demo-4/cats/1.png', 'title' => 'Computer & Laptop'],
    ['image' => 'assets/images/demos/demo-4/cats/2.png', 'title' => 'Digital Cameras'],
    ['image' => 'assets/images/demos/demo-4/cats/3.png', 'title' => 'Smart Phones'],
    ['image' => 'assets/images/demos/demo-4/cats/4.png', 'title' => 'Televisions'],
    ['image' => 'assets/images/demos/demo-4/cats/5.png', 'title' => 'Audio'],
    ['image' => 'assets/images/demos/demo-4/cats/6.png', 'title' => 'Smart Watches'],
];
@endphp

<div class="container">
    <h2 class="title text-center mb-4">Explore Popular Categories</h2>
    <div class="cat-blocks-container">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="#" class="cat-block">
                        <figure><span><img src="{{ asset($category['image']) }}" alt="Category image"></span></figure>
                        <h3 class="cat-block-title">{{ $category['title'] }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>