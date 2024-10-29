@extends('pages.components.layout')

@section('content')
    <div class="title-container">
        <h1 style="font-size: 50px; font-family: sans-serif; text-align: center;">A Furniture that eases your life</h1>
        <p style="text-align: center; margin-top: -20px; color: rgb(105, 105, 105);">
            Explore world-class top furniture as per your requirements and choice
        </p>
    </div>
    <div class="front-background-image">
        <a href="{{ route('products') }}" style="text-decoration: none;">
            Shop now <span class="material-symbols-outlined">chevron_right</span>
        </a>
    </div>
    <div class="category-container">
        <h1 style="text-align: center;">Preferred Category</h1>
        <div class="categories">
            @if ($categories->isEmpty())
                @foreach (['mirror', 'bed', 'cushion', 'sofa', 'chair', 'lamp'] as $item)
                    <div class="category" style="background-image: url({{ asset('assets/img/' . $item . '.avif') }});"
                        data-aos="fade-up"
                        data-aos-duration="{{ 500 + 200 * array_search($item, ['mirror', 'bed', 'cushion', 'sofa', 'chair', 'lamp']) }}">
                        <h2>{{ ucfirst($item) }}</h2>
                    </div>
                @endforeach
            @else
                @foreach ($categories as $category)
                    <a href="{{ route('products', ['category' => $category->id]) }}" class="category"
                        style="background-image: url({{ asset('storage/' . $category->image) }});" data-aos="fade-up"
                        data-aos-duration="500">
                        <h2 style="color: black">{{ $category->name }}</h2>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
    <div class="new-product-container-title">
        <h1 style="font-family: sans-serif;">New Products</h1>
    </div>
    <div class="new-products-container">
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach ($newProducts as $product)
                    <div class="swiper-slide">
                        <a href="{{ route('product', $product->id) }}">
                            @if($product->image)
                            <img src="{{ asset('storage/images/products/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                            <img src="{{ asset('assets/img/not-found.png') }}" alt="{{ $product->name }}" style="object-fit:fill;">
                            @endif
                            <div class="swiper-description">
                                <h1 data-aos="fade-up" data-aos-duration="700" data-aos-anchor-placement="center"
                                    style="color: black">
                                    {{ $product->name }}</h1>
                                <h2 data-aos="fade-up" data-aos-duration="900" data-aos-anchor-placement="center-bottom"
                                    style="color: black">
                                    {{ $product->price }}</h2>
                                <h2 data-aos="fade-up" data-aos-duration="900" data-aos-anchor-placement="center-bottom"
                                    style="color: black">
                                    {{ $product->description }}
                                </h2>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="grid-container">
            @foreach ($newProducts as $product)
                <a href="{{ route('product', $product->id) }}" style="text-decoration: none;">
                    <div class="grid-1 grid">
                        <img src="{{ $product->image ? asset('storage/images/products/' . $product->image) : asset('assets/img/not-found.png') }}"
                            alt="{{ $product->name }}" style="object-fit:fill;">
                        <div class="grid-product-description">
                            <h2 style="color: black">{{ $product->name }}</h2>
                            <div class="rating">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $product->rating)
                                        <i class="fa-solid fa-star text-black"></i>
                                    @else
                                        <i class="fa-solid fa-star text-black"></i>
                                    @endif
                                @endfor
                                <span style="padding-left: 10px;">{{ $product->rating }}</span>
                                <p style="color: black">{{ $product->ratings->count() }} reviews</p>
                            </div>
                            <div class="price">
                                <h3 style="color: black">${{ $product->price }}</h3>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="one-page-sale-container">
        <div class="one-page-sale-container-description">
            <p style="font-family: sans-serif; margin-bottom: -20px;" data-aos="fade-up" data-aos-duration="500">Mega sale
                up to 75%</p>
            <h1 data-aos="fade-up" data-aos-duration="500">Fancy Sofa Set</h1>
            <p style="font-family: sans-serif; line-height: 25px; color: gray;" data-aos="fade-up" data-aos-duration="700">
                This beautiful sofa set is the perfect addition to any living room. The plush cushions and comfortable
                design will make you want to curl up and relax for hours on end.
            </p>
            <div class="product-container-one-sale" data-aos="fade-up" data-aos-duration="900">
                <img src="{{ asset('assets/img/white-lounge-chair.jpg') }}" alt="White Lounge Chair">
                <div class="product-description-one-sale">
                    <h2>White Lounge Chair</h2>
                    <span
                        style="font-size: 25px; font-family: sans-serif; font-weight: bold; margin-right: 10px;">$35.00</span>
                    <span style="color: gray; text-decoration: line-through;">$50.00</span>
                </div>
            </div>
            <div class="product-container-one-sale" data-aos="fade-up" data-aos-duration="900">
                <img src="{{ asset('assets/img/book-case.jpg') }}" alt="Edward Minimalist Bookcase">
                <div class="product-description-one-sale">
                    <h2>Edward Minimalist Bookcase 2x5</h2>
                    <span
                        style="font-size: 25px; font-family: sans-serif; font-weight: bold; margin-right: 10px;">$28.72</span>
                    <span style="color: gray; text-decoration: line-through;">$35.00</span>
                </div>
            </div>
            <div class="button-container" style="display: flex; justify-content: center;">
                <button data-aos="fade-up" data-aos-duration="1000" data-aos-anchor-placement="top-bottom">
                    Explore Collection <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
        <div class="one-page-sale-container-image"></div>
    </div>
@endsection
