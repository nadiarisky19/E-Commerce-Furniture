<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='sales'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Sales"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Sales Detail</h6>
                            <a href="{{ route('sales.index') }}" class="btn btn-primary btn-sm">Back</a>
                        </div>
                        <div class="card-body px-3 pt-3 pb-2">
                            <h5>Product Information</h5>
                            <div class="mb-3">
                              @if ($sale->product->image)
                              <strong>Product Image:</strong>
                                    <img src="{{ asset('storage/products/' . $sale->product->image) }}" alt="{{ $sale->product->name }}" class="img-fluid">
                                @else
                                <strong>Product Image:</strong> No image available
                                @endif
                                <br>
                                <strong>Product Name:</strong> {{ $sale->product->name }}<br>
                                <strong>Product Description:</strong> {{ $sale->product->description }}<br>
                                <strong>Product Price:</strong> ${{ number_format($sale->product->price, 2) }}<br>
                                <strong>Category:</strong> {{ $sale->product->category->name }}<br>
                                

                            </div>

                            <!-- Admin-Only Information -->
                            @if(auth()->user()->role === 'admin')
                                <hr>
                                <h5>Seller Information</h5>
                                <div class="mb-3">
                                    <strong>Seller Name:</strong> {{ $sale->product->seller->user->name }}<br>
                                    <strong>Seller Email:</strong> {{ $sale->product->seller->user->email }}<br>
                                    <strong>Seller Phone:</strong> {{ $sale->product->seller->user->phone ?? 'N/A' }}<br>
                                </div>

                                <hr>
                                <h5>Buyer Information</h5>
                                <div class="mb-3">
                                    <strong>Buyer Name:</strong> {{ $sale->wallet->user->name }}<br>
                                    <strong>Buyer Email:</strong> {{ $sale->wallet->user->email }}<br>
                                    <strong>Buyer Phone:</strong> {{ $sale->wallet->user->phone ?? 'N/A' }}<br>
                                    <strong>Buyer Address:</strong> {{ $sale->wallet->user->address ?? 'N/A' }}<br>
                                </div>

                                <hr>
                                <h5>Sale Information</h5>
                                <div class="mb-3">
                                    <strong>Date of Purchase:</strong> {{ $sale->created_at->format('Y-m-d') }}<br>
                                    <strong>Sale ID:</strong> {{ $sale->id }}<br>
                                    <strong>Total:</strong> ${{ number_format($sale->total, 2) }}<br>
                                    <strong>Quantity Purchased:</strong> {{ $sale->quantity }}<br>
                                    
                                <strong>Status:</strong> <span class="badge 
                                    @if($sale->status === 'completed') bg-success
                                    @elseif($sale->status === 'pending') bg-warning
                                    @elseif($sale->status === 'canceled') bg-danger
                                    @endif">
                                    {{ ucfirst($sale->status) }}
                                </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
