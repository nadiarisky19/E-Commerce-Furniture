@extends('pages.components.layout')
@section('content')
    <h1 class="current-best-selling-products-h1">Current Best Selling Products</h1>
    <div class="current-best-selling-products">
        @foreach ($topProducts as $product)
            <div class="current-best-selling-product" data-aos="fade-up" data-aos-duration="700">
                <!-- Dynamic Product Image -->
                @if ($product->image)
                    <img src="{{ asset('storage/images/product' . $product->iimage) }}" alt="{{ $product->name }}">
                @else
                    <img src="/assests/living room/marigold sofa.jpg" alt="">
                @endif

                <div class="current-best-selling-products-description">
                    <!-- Product Name -->
                    <h2>{{ $product->name }}</h2>

                    <!-- Star Reviews (assuming a rating of 4.5 as an example) -->
                    <div class="star-reviews" style="margin-top: -20px; margin-bottom: -10px;">
                        @for ($i = 0; $i < floor($product->rating); $i++)
                            <i class="fas fa-star" style="color: gold;"></i>
                        @endfor
                        @if ($product->rating - floor($product->rating) >= 0.5)
                            <i class="fas fa-star-half-alt" style="color: gold;"></i>
                        @endif
                    </div>

                    <!-- Rating and Review Count -->
                    <p style="margin-bottom: -10px;">{{ number_format($product->rating, 1) }} ({{ $product->review_count }}
                        Reviews)</p>

                    <!-- Product Price -->
                    <h3 style="font-family: 'Poppins';">{{ number_format($product->price, 2) }} <span>USD</span></h3>
                </div>
            </div>
        @endforeach

    </div>
    <div class="living-room-products">
        @foreach ($products as $product)
            <a href="{{ route('product', ['id' => $product->id]) }}" style="text-decoration: none">
                <div class="product">
                    @if ($product->image)
                        <img src="{{ asset('storage/images/product' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('assets/img/side table.jpg') }}" alt="">
                    @endif
                    <div class="product-description"
                        style="display: flex;flex-direction: column;align-items: center;justify-content: center;">
                        <h2>{{ $product->name }}</h2>
                        <div class="star-reviews" style="margin-top: -20px;margin-bottom: -10px;">
                            @for ($i = 0; $i < floor($product->rating); $i++)
                                <i class="fas fa-star" style="color: gold;"></i>
                            @endfor
                            @if ($product->rating - floor($product->rating) >= 0.5)
                                <i class="fas fa-star-half-alt" style="color: gold;"></i>
                            @endif
                        </div>
                        <p style="margin-bottom: -10px;">{{ number_format($product->rating, 1) }}
                            ({{ $product->review_count }} Reviews)
                        </p>
                        <h3 style="font-family: 'Poppins';">{{ number_format($product->price, 2) }} <span>USD</span></h3>
                    </div>
                </div>
            </a>
        @endforeach

    </div>
    <div class="count-container">
        <p style="border:1px solid;border-radius: 50%;padding:7px 15px;">1</p>
        <p>2</p>
        <p>3</p>
        <p>.</p>
        <p>.</p>
        <p>.</p>
        <p>9</p>
        <i class="fa-solid fa-chevron-right"></i>
    </div>
@endsection
