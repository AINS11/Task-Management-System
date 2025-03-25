@extends('layouts.app')

@section('title', 'Register')

@section('content')

    <div class="login-container">
        <h2 class="login-title">Register</h2>
        @if (session(('failed')))
        <div class="error-toastr">
            <span>{{ session(('failed')) }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name Input -->
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name"  placeholder="Enter your name">
                @if(session()->has('error.name'))
                <div class="text-danger">
                    {{ session('error')['name'][0] }}
                </div>
                 @endif
            </div>

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
            <button type="submit" class="login-btn">Register</button>

            <!-- Links -->
            <div class="login-links">
                <span class="text-light">Already have account? </span> <a href="{{ route('login') }}">Login Here</a>
            </div>
        </form>
    </div>
    @endsection

