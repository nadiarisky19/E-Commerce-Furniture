<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='products'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Products"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Product List</h6>
                            @if (Auth::user()->isSeller())
                                <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">Create</a>                            
                            @endif
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                            @if (Auth::user()->isAdmin())
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Seller</th>
                                            @endif
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td class="text-center">{{ $product->id }}</td>
                                                <td class="text-center">{{ $product->name }}</td>
                                                <td class="text-center">{{ $product->category->name }}</td>
                                                @if (Auth::user()->isAdmin())
                                                <td class="text-center">{{ $product->seller->user->name }}</td>
                                                @endif
                                                <td class="text-center">${{ number_format($product->price, 2) }}</td>
                                                <td class="text-center">{{ $product->stock }}</td>
                                                <td class="text-center text-{{$product->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ $product->status }}
                                                </td>

                                                <td class="text-center">
                                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                                                    @if (Auth::user()->isSeller())
                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($products->isEmpty())
                                    <div class="alert alert-warning text-center">No products found.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
