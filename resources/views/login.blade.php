<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="icon" type="image/x-icon" href="/image/android-chrome-512x512.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<div class="login">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="inner-img">
                    <img src="/image/login.jpg" alt="" class="image">
                </div>
            </div>
            <div class="col-xl-6 col-md-6 col-lg-12">
                <div class="inner-form" style="color: #1b1e21">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('login')}}" method="post">
                        @csrf
                        <label for="email">Tên đăng nhập</label>
                        <input type="text" name="email" id="email" class="form-control">
                        <label for="password">Mật khẩu</label>
                        <input type="password" name="password" id="password" class="form-control" >
                        <button type="submit">Đăng Nhập</button>
                        <div class="inner-line"></div>
                        <div class="register">
                            <span>Bạn chưa có tài khoản?</span>
                            <a href="{{route('register')}}" class="">Tạo tại đây</a>
                        </div>
                    </form>
                    <div>
                    <a href="{{route('home')}}" class="inner-back">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
