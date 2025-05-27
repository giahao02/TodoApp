<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Chào {{ Auth::user()->name }}</h2>

    <p>Bạn đã đăng nhập thành công!</p>

    {{-- Nút đăng xuất --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Đăng xuất</button>
    </form>
</body>
</html>
