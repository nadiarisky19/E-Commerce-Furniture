@extends('pages.components.layout')
@section('content')
    <div class="product-container">
        <div class="product-image">
            @if ($product->image)
                <img src="{{ asset('storage/images/products/' . $product->image) }}" alt="{{ $product->name }}"
                    id="main-product-image" style="height: 500px;width: 500px;">
            @else
                <img src="/assests/living room/malskar chair/productimg1.avif" alt="" id="main-product-image"
                    style="height: 500px;width: 500px;">
            @endif
        </div>
        <div class="product-description">
            <h1 class="product-title-chair">{{ $product->name }}</h1>
            <div class="product-chair-cost">
                <h1 style="font-size: 35px;font-family: 'Poppins';font-weight: bolder;padding-right: 20px;">
                    ${{ $product->price }}</h1>

            </div>
            <!-- Section Deskripsi Produk dan Seller -->
            <div class="product-seller-description">
                <h2>Product Description</h2>
                <p>{{ $product->description }}</p>

            </div>
            <div class="stock-and-counter">
                <p>Stock: {{ $product->stock }} left</p>
                <div class="counter">
                    <p id="stock-minus" style="cursor: pointer;font-size: 30px;">-</p>
                    <p id="stock-value">1</p>
                    <p id="stock-plus" style="cursor: pointer;font-size: 20px;">+</p>
                </div>
            </div>
            <div class="product-submit-container">
                <i class="fa-regular fa-heart"
                    style="font-size: 25px;cursor: pointer;border: 2px solid;padding:15px;border-radius: 50%;color:red"
                    id="heart-icon"></i>
                <!-- Tombol Add to Cart -->
                <form action="{{ route('carts.store', $product->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="wallet_id" value="{{ Auth::user()->wallet->id }}">
                    <input type="hidden" name="quantity" value="1" id="quantity">
                    <button type="submit" id="add-to-cart-btn" class="add-to-cart-button"><i
                            class="fa-solid fa-cart-shopping" style="padding-right: 20px;"></i>Add to Cart</button>
                </form>
                <!-- Tombol Chat to Seller -->
                <button id="chat-to-seller-btn" class="chat-to-seller-button">
                    <i class="fa-solid fa-comment-dots" style="padding-right: 10px;"></i>Chat to Seller
                </button>
            </div>
        </div>
    </div>
    <h1 class="current-best-selling-products-h1" style="margin-top: 50px;">Good Matching Products</h1>
    <div class="current-best-selling-products">
        @foreach ($matches as $matchProduct)
            <a href="{{ route('product', $matchProduct->id) }}" style="text-decoration: none">
                <div class="current-best-selling-product" data-aos="fade-up" data-aos-duration="500">
                    @if ($matchProduct->image)
                        <img src="{{ asset('storage/images/products/' . $matchProduct->image) }}"
                            alt="{{ $matchProduct->name }}">
                    @else
                        <img src="/assests/living room/malskar chair/productimg1.avif" alt="">
                    @endif
                    <div class="current-best-selling-products-description">
                        <h2 style="color: black">{{ $matchProduct->name }}</h2>
                        <div class="star-reviews" style="margin-top: -20px;margin-bottom: -10px;">
                            @for ($i = 0; $i < floor($matchProduct->rating); $i++)
                                <i class="fa-solid fa-star" style="color: gold;"></i>
                            @endfor
                            @if ($matchProduct->rating - floor($matchProduct->rating) >= 0.5)
                                <i class="fa-solid fa-star-half-stroke" style="color: gold;"></i>
                            @endif
                        </div>
                        <p style="margin-bottom: -10px;color:black;">{{ number_format($matchProduct->rating, 1) }}
                            ({{ $matchProduct->review_count }} Reviews)
                        </p>
                        <h3 style="font-family: 'Poppins';color:black;">{{ $matchProduct->price }}</h3>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stockMinus = document.getElementById("stock-minus");
            const stockPlus = document.getElementById("stock-plus");
            const stockValue = document.getElementById("stock-value");
            const quantityInput = document.getElementById("quantity");
            const maxStock = {{ $product->stock }}; // Maksimum stok produk

            stockMinus.addEventListener("click", () => {
                let quantity = parseInt(stockValue.textContent);
                if (quantity > 1) {
                    quantity--;
                    stockValue.textContent = quantity;
                    quantityInput.value = quantity;
                }
            });

            stockPlus.addEventListener("click", () => {
                let quantity = parseInt(stockValue.textContent);
                if (quantity < maxStock) {
                    quantity++;
                    stockValue.textContent = quantity;
                    quantityInput.value = quantity;
                }
            });
        });
    </script>

@endsection
