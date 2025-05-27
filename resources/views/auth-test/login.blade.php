<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>

    {{-- Thông báo thành công (vd: sau khi đăng ký xong hoặc đăng xuất) --}}
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Hiển thị lỗi đăng nhập --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
        </div>

        <div>
            <input type="password" name="password" placeholder="Mật khẩu" required>
        </div>

        <div>
            <button type="submit">Đăng nhập</button>
        </div>
    </form>

    <p>Bạn chưa có tài khoản? <a href="{{ route('register.form') }}">Đăng ký</a></p>
</body>
</html>
