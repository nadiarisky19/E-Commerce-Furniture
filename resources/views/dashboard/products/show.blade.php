<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='products'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Product Details"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Product Details</h6>
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">Back</a>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            @if ($product->image)
                                <img src="{{ asset('storage/images/products/' . $product->image) }}"
                                    class="img-fluid mb-3" alt="Product Image" width="150" height="150"
                                    style=" object-fit: cover; border-radius: 25%;">
                            @else
                                <p>No image available</p>
                            @endif
                            <!-- Display Product Information -->
                            <h5>Product Name: {{ $product->name }}</h5>
                            <p>Description: {{ $product->description }}</p>
                            <p>Price: ${{ number_format($product->price, 2) }}</p>
                            <p>Stock: {{ $product->stock }}</p>
                            <p>Status: {{ ucfirst($product->status) }}</p>

                            <!-- Display Seller Information only if the user is an admin -->
                            @if (auth()->user()->role === 'admin')
                                <hr>
                                <h5>Seller Information</h5>
                                <p>Seller Name: {{ $product->seller->user->name }}</p>
                                <p>Seller Email: {{ $product->seller->user->email }}</p>
                                <p>Seller Phone: {{ $product->seller->user->phone ?? 'N/A' }}</p>
                                <p>Seller Address: {{ $product->seller->user->address ?? 'N/A' }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
