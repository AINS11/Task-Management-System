@extends('layouts.app')

@section('title', 'Login')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
@endpush

@section('content')
    <div class="login-container">
        
        <h2 class="login-title">Login</h2>
        @if (session(('failed')))
        <div class="error-toastr">
            <span>{{ session(('failed')) }}</span>
        </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email Input -->
            <div class="input-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">

                @if(session()->has('error.email'))
                <div class="text-danger">
                    {{ session('error')['email'][0] }}
                </div>
            @endif
            </div>

            <!-- Password Input -->
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
                @if(session()->has('error.password'))
                <div class="text-danger">
                    {{ session('error')['password'][0] }}
                </div>
            @endif
            </div>

            <!-- Login Button -->
            <button type="submit" class="login-btn">Login</button>

            <!-- Links -->
            <div class="login-links">
                <a href="{{ route('register') }}">Sign Up</a> -
            </div>
        </form>
    </div>
@endsection
