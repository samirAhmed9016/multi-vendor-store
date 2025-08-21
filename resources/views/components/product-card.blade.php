<!-- Start Single Product -->

{{-- <x-slot name="breadcrumbs">
        <!-- Start Breadcrumbs Area -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Home</h1>
                            <h1 class="page-title">@yield('page-title', 'Home')</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            @yield('breadcrumb')
                            <li><a href="index.html"><i class="lni lni-home"> home</i></a></li>
                            <li>login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs Area -->
    </x-slot>   --}}



<div class="single-product">
    <div class="product-image">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        @if ($product->discount_percentage)
            <span class="sale-tag">{{ $product->discount_percentage }}%</span>
        @endif

        @if ($product->is_new)
            <span class="new-tag ">New</span>
        @endif
        <div class="button">
            <a href={{ route('product.show', $product->slug) }} class="btn"><i class="lni lni-cart"></i> Add to
                Cart</a>
        </div>
    </div>
    <div class="product-info">
        <span class="category">{{ $product->category->name }}</span>
        <h4 class="title">
            <a href={{ route('product.show', $product->slug) }}>{{ $product->name }}</a>
        </h4>
        <ul class="review">
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><span>5.0 Review(s)</span></li>
        </ul>
        <div class="price">
            <span>{{ Currency::format($product->price) }}</span>
            @if ($product->compare_price)
                <span class="discount-price">{{ Currency::format($product->compare_price) }}</span>
            @endif
        </div>
    </div>
</div>
<!-- End Single Product -->
