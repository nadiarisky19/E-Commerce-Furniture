<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='products'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Product"></x-navbars.navs.auth>
        <!-- End Navbar -->

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center pb-0">
                            <h6>Edit Product</h6>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">Back</a>
                        </div>

                        <div class="card-body px-4">
                            <form action="{{ route('products.update', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <!-- Name Input -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $product->name) }}" required>
                                </div>

                                <input type="hidden" name="seller_id" value="{{ Auth::user()->seller->id }}">
                                <!-- Category Dropdown -->
                                <div class="input-group input-group-dynamic mb-4">
                                    <label for="category_id" class="form-label"></label>
                                    <select class="form-select" name="category_id" id="category_id" required>
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Description Textarea -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" rows="3" spellcheck="false" id="description" required>{{ old('description', $product->description) }}</textarea>
                                </div>

                                <!-- Price Input -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" id="price" name="price"
                                        value="{{ old('price', $product->price) }}" step="0.01" required>
                                </div>

                                <!-- Stock Input -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="stock">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                        value="{{ old('stock', $product->stock) }}" required>
                                </div>

                                <!-- Status Dropdown -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="status" class="form-label"></label>
                                    <select class="form-select" name="status" id="status" required>
                                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive"
                                            {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <!-- Image Upload -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control mt-3" name="image" id="profilePicInput"
                                        accept="image/*">
                                </div>

                                <!-- Display Existing Image -->
                                @if ($product->image)
                                    <div class="mb-4">
                                        <label class="form-label">Current Image</label><br>
                                        <img src="{{ asset('storage/images/products/' . $product->image) }}"
                                            alt="Product Image" class="img-thumbnail" id="profilePic"
                                            style="max-width: 150px;">
                                    </div>
                                @endif

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-100">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<script>
    // Preview the selected image
    document.getElementById('profilePicInput').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const profilePic = document.getElementById('profilePic');
            profilePic.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
