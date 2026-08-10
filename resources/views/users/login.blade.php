@extends('layouts.auth')

@section('content')

<div class="login-card">

    <div class="text-center">

        <div class="logo">
            🛒
        </div>

        <h2>POS</h2>

        <p>Point Of Sales System</p>

    </div>

  <form action="{{ route('auth') }}" method="POST">

    @csrf

    <div class="mb-3">
        <label>Email</label>

        <input
            type="email"
            name="email"
            class="form-control"
            placeholder="Masukkan Email"
            required>
    </div>

    <div class="mb-4">
        <label>Password</label>

        <input
            type="password"
            name="password"
            class="form-control"
            placeholder="Masukkan Password"
            required>
    </div>

    <button type="submit" class="btn btn-login w-100">
        Login
    </button>

</form>

</div>

@endsection