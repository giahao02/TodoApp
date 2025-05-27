<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
</head>
<body>
    <h2>Đăng ký</h2>

    {{-- Hiển thị thông báo thành công --}}
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Hiển thị lỗi validation --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Tên" required>
        </div>

        <div>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
        </div>

        <div>
            <input type="password" name="password" placeholder="Mật khẩu" required>
        </div>

        <div>
            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
        </div>

        <div>
            <button type="submit">Đăng ký</button>
        </div>
    </form>

    <p>Bạn đã có tài khoản? <a href="{{ route('login.form') }}">Đăng nhập</a></p>
</body>
</html>
