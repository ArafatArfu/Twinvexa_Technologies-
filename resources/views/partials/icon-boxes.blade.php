@php
use App\Models\IconBox;
$iconBoxes = IconBox::active()->ordered()->get();
@endphp

<div class="icon-boxes-container bg-transparent">
    <div class="container">
        <div class="row">
            @foreach($iconBoxes as $box)
                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            @if($box->icon_image)
                                <img src="{{ asset('storage/' . $box->icon_image) }}" alt="{{ $box->title }}" width="40" height="40" style="max-width:40px;max-height:40px;">
                            @else
                                <i class="{{ $box->icon_class }}"></i>
                            @endif
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">{{ $box->title }}</h3>
                            <p>{{ $box->subtitle }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
