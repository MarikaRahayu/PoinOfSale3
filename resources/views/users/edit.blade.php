@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<style>
body {
    background-color: #fff0f6;
}

/* Card */
.user-card {
    background: white;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(214, 51, 132, 0.15);
}

/* Judul */
.user-title {
    color: #d63384;
    font-weight: bold;
    margin-bottom: 25px;
}

/* Form */
.form-label {
    color: #8b1e52;
    font-weight: 600;
}

.form-control,
.form-select {
    border: 2px solid #ffc1dc;
    border-radius: 12px;
    padding: 10px;
}

.form-control:focus,
.form-select:focus {
    border-color: #ff69b4;
    box-shadow: 0 0 8px rgba(255, 105, 180, 0.4);
}

/* Animasi */
.user-card {
    animation: muncul 0.5s ease;
}

@keyframes muncul {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<div class="container mt-5">
    <div class="user-card">

        <h3 class="user-title">
            Edit User
        </h3>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            @include('users._form')
        </form>

    </div>
</div>

@endsection
