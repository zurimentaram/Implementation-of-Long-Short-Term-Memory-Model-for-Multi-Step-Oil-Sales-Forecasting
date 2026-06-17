<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: #f3f4f6;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #111827;
            color: #fff;
            padding: 20px 0;
        }
        .sidebar .brand {
            padding: 0 20px 20px;
            font-weight: 700;
            font-size: 18px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #cbd5e1;
            text-decoration: none;
            transition: .2s;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background: #1f2937;
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 24px;
        }
        .topbar {
            background: #fff;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">Forecasting Sells</div>

        <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ url('/penjualan') }}" class="{{ request()->is('penjualan*') ? 'active' : '' }}">Data Penjualan</a>
        <a href="{{ url('/prediksi') }}" class="{{ request()->is('prediksi*') ? 'active' : '' }}">Prediksi</a>
        <a href="{{ url('/evaluasi') }}" class="{{ request()->is('evaluasi*') ? 'active' : '' }}">Evaluasi</a>

        <form method="POST" action="{{ route('logout') }}" class="px-3 mt-3">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </div>

    <div class="content">
        <div class="topbar d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@yield('page_title', 'Dashboard')</h5>
            <div class="text-muted">{{ config('app.name', 'Laravel') }}</div>
        </div>

        @yield('content')
    </div>
</body>
</html>