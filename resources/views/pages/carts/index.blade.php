@extends('pages.components.layout')

@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="container mt-5">
        <h2>Your Cart</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="cart-form" action="{{ route('sales.store') }}" method="POST">
            @method('POST')
            @csrf
            <div class="list-group mb-3">
                @foreach ($carts as $cart)
                    <div class="list-group-item d-flex justify-content-between align-items-center cart-item"
                        data-cart-id="{{ $cart->id }}">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="cartItems[]" value="{{ $cart->id }}"
                                class="form-check-input me-2 cart-checkbox">
                            <img src="{{ $cart->product->image ? asset('storage/images/products/' . $cart->product->image) : 'https://via.placeholder.com/50' }}"
                                alt="{{ $cart->product->name }}" width="50" height="50" class="me-2">
                            <div>
                                <strong>{{ $cart->product->name }}</strong>
                                <div>Price: Rp. <span
                                        class="product-price">{{ number_format($cart->product->price, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <input type="number" name="quantities[{{ $cart->id }}]" value="{{ $cart->quantity }}"
                                min="1" class="form-control quantity-input me-2" style="width: 80px;"
                                data-cart-id="{{ $cart->id }}" data-price-per-item="{{ $cart->product->price }}">
                            <span class="text-muted me-2">Total: Rp. <span
                                    class="item-price">{{ number_format($cart->quantity * $cart->product->price, 2, ',', '.') }}</span></span>
                            <button type="button" class="btn btn-danger btn-sm remove-btn"
                                data-cart-id="{{ $cart->id }}">Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-footer d-flex justify-content-between align-items-center">
                <span>Total: Rp. <span id="total-price">0</span></span>
                <button type="submit" class="btn btn-primary">Checkout</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantities = document.querySelectorAll('.quantity-input');
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            const totalPriceElement = document.getElementById('total-price');
            const removeButtons = document.querySelectorAll('.remove-btn');

            function updateTotalPrice() {
                let totalPrice = 0;

                quantities.forEach(function(input) {
                    const pricePerItem = parseFloat(input.dataset.pricePerItem);
                    const quantity = parseInt(input.value) || 0; // Default to 0 if NaN
                    const newPrice = quantity * pricePerItem;
                    const itemPriceElement = input.closest('.list-group-item').querySelector('.item-price');

                    // Update individual item price display
                    itemPriceElement.innerText = newPrice.toFixed(2).replace('.', ',');

                    // Only add to total if checkbox is checked
                    if (input.closest('.list-group-item').querySelector('.cart-checkbox').checked) {
                        totalPrice += newPrice;
                    }
                });

                totalPriceElement.innerText = totalPrice.toFixed(2).replace('.', ',');
            }

            async function saveQuantity(cartId, quantity) {
                await fetch(`/carts/${cartId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error('Error saving quantity:', data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            async function removeCartItem(cartId) {
                await fetch(`/carts/${cartId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const itemElement = document.querySelector(`[data-cart-id="${cartId}"]`);
                            itemElement.remove();
                            updateTotalPrice();
                        } else {
                            console.error('Error removing item:', data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            quantities.forEach(function(input) {
                const itemPriceElement = input.closest('.list-group-item').querySelector('.item-price');
                const pricePerItem = parseFloat(input.dataset.pricePerItem);
                itemPriceElement.dataset.pricePerItem = pricePerItem;

                input.addEventListener('change', function() {
                    const cartId = input.closest('.cart-item').dataset
                        .cartId; // Use dataset to get cart ID
                    const quantity = parseInt(input.value);
                    saveQuantity(cartId, quantity);
                    updateTotalPrice();
                });
            });

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateTotalPrice);
            });

            removeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const cartId = button.dataset.cartId;
                    if (confirm('Are you sure you want to remove this item from the cart?')) {
                        removeCartItem(cartId);
                    }
                });
            });

            updateTotalPrice(); // Initial total price calculation
        });
    </script>
@endsection

@section('styles')
    <style>
        .cart-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        .cart-item img {
            border-radius: 50%;
        }
    </style>
@endsection
