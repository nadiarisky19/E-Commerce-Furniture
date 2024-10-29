<div class="header-container">
    <div class="logo">
        <a href="{{ route('welcome') }}"
            style="text-decoration: none; color: black; font-family: sans-serif;">HomeFurniPlace</a>
    </div>
    <div class="input-field">
        <input type="text" placeholder="Search in Emmable">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>
    <div class="user-data">
        <div class="cart-details">
            <a href="{{ route('carts.index') }}" style="color: gray;">
                <i class="fa-solid fa-cart-shopping" id="cart-button"></i>
            </a>
        </div>
        @if (Auth::user())
            <a href="{{ route('profile-user.index') }}" style="color: gray;">
                <i class="fa-solid fa-user text-gray-600"></i>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-1 py-2">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="px-2 py-3">
                Login
            </a>
        @endif
    </div>
</div>
