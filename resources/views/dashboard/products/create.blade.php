<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='products'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Create Product"></x-navbars.navs.auth>
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
                            <h6>Create Product</h6>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">Back</a>
                        </div>

                        <div class="card-body px-4">
                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Name Input -->
                                <div class="input-group input-group-outline mb-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <input type="hidden" name="seller_id" value="{{ Auth::user()->seller->id }}">
                                <!-- Category Dropdown -->
                                <div class="input-group input-group-dynamic mb-4">
                                    <select class="form-select" name="category_id" id="category_id" required>
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Description Textarea -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" rows="3" spellcheck="false" id="description" required></textarea>
                                </div>

                                <!-- Price Input -->
                                <div class="input-group input-group-outline mb-4">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
                                </div>

                                <!-- Stock Input -->
                                <div class="input-group input-group-outline mb-4">
                                    <label for="stock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" required>
                                </div>

                                <!-- Status Dropdown -->
                                <div class="input-group input-group-static mb-4">
                                    <select class="form-select" name="status" id="status" required>
                                        <option value="">Select a Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                <!-- Image Upload -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control mt-3" name="image" id="profilePicInput"
                                        accept="image/*">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
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
            profilePic.src = reader.result; // Set the image source to the FileReader result
        }
        reader.readAsDataURL(event.target.files[0]); // Read the uploaded file as a data URL
    });
</script>
