@extends('pages.components.layout')
@section('content')
    <div class="profile-container">
        <div class="profile-header">
            @if (Auth::user()->image)
                <img src="{{ asset('storage/images/users/' . Auth::user()->image) }}" alt="Profile Picture"
                    class="profile-pic">
            @else
                <img src="https://via.placeholder.com/150" alt="Profile Picture" class="profile-pic">
            @endif
            <h3 class="profile-username">{{ Auth::user()->username }}</h3>
        </div>

        <div class="profile-details">
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Address:</strong> {{ Auth::user()->address ?? '-' }}</p>
            <p><strong>Phone Number:</strong> {{ Auth::user()->phone ?? '-' }}</p>
            <p><strong>Date of Birth:</strong> {{ Auth::user()->date_of_birth ?? '-' }}</p>
            <p><strong>Wallet Balance:</strong> ${{ Auth::user()->wallet->balance ?? '0' }}</p>
        </div>

        <div class="profile-actions">
            <a href="{{ route('profile-user.edit') }}" class="btn btn-primary">Edit Profile</a>
            @if (Auth::user()->wallet)
                <a href="{{ route('wallets-users.index') }}" class="btn btn-secondary">View Wallet</a>
            @else
                <a href="{{ route('wallets-users.create') }}" class="btn btn-secondary">Create Wallet</a>
            @endif
        </div>
    </div>
@endsection
