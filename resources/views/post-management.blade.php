<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài đăng</title>
    <link rel="icon" type="image/x-icon" href="/image/android-chrome-512x512.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,200"/>
    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/contact.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/management.css">
</head>
<body>
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="inner-head">
                    <div class="inner-logo">
                        <a href="{{route ('admin.home')}}">
                            <img src="/image/logo.png" alt="logo">
                        </a>
                    </div>
                    <div class="inner-menu">
                        <ul class="menu">
                            <li><a href="{{route('admin.home')}}" class="active-menu">Trang Chủ</a></li>
                            <li><a href="{{route('user.management')}}">Quản Lí Người Dùng</a></li>
                            <li><a href="{{route('post.management')}}">Quản Lí Bài Đăng</a></li>
                            <li><a href="{{route('comment.management')}}">Quản Lí Bình Luận</a></li>
                        </ul>
                    </div>
                    <div class="user-dropdown">
                        <div class="dropdown-toggle">
                            <i class="fa-solid fa-user"></i>
                            <span>{{$user->full_name}}</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('admin.profile')}}">Quản Lí Cá Nhân</a></li>
                            <li><a href="{{route ('logout')}}">Đăng Xuất</a></li>
                        </ul>
                    </div>
                    <div class="inner-menu-mb">
                        <div class="menu-mb-icon"><i class="fa-solid fa-bars"></i></div>
                        <ul class="menu-mb">
                            <li><a href="{{route('admin.home')}}" class="active-menu"><i class="fa-solid fa-house"></i>Trang Chủ</a></li>
                            <li><a href="{{route('user.management')}}"><i class="fa-solid fa-house"></i>Quản Lí Người Dùng</a></li>
                            <li><a href="{{route('post.management')}}"><i class="fa-solid fa-house"></i>Quản Lí Bài Đăng</a></li>
                            <li><a href="{{route('comment.management')}}"><i class="fa-solid fa-house"></i>Quản Lí Bình Luận</a></li>
                            <li class="item-action">
                                <a href="{{route('login')}}">Đăng Nhập</a>
                                <a href="{{route('logout')}}">Đăng Xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="style-body" style="overflow-x: auto;">
    <h1>Danh sách bài đăng</h1>
    <table border="1">
        <thead>
        <tr>
            <th>Tiêu Đề</th>
            <th>Giá</th>
            <th>Địa Chỉ</th>
            <th>Miêu Tả</th>
            <th>Hình Ảnh</th>
            <th>Tiện Ích</th>
            <th>Ngày Đăng</th>
            <th>Người Đăng</th>
            <th>Đánh Giá</th>
            <th>Tình Trạng</th>
        </tr>
        </thead>
        <tbody>
        @if ($posts->isNotEmpty())
        @foreach ($posts as $post )
        <tr>
            <td>
                <a href="{{ route('post.detail', ['id' => $post->id]) }}">
                    {{ $post->title }}
                </a>
            </td>
            <td>{{ number_format($post->price, 0, ',', '.') }} VND</td>
            <td class="break-word">
                <a href="{{ $post->location->link}}" target="_blank">{{ $post->location->address}}</a>
            </td>
            <td>{{ $post->description }}</td>
            <td>
                <ul>
                    @foreach($post->listImages as $image)
                        <li>
                            <img src="{{ asset('storage/' . $image->url) }}" alt="Post Image" class="image" style="width:100px; height:auto;"/>
                        </li>
                    @endforeach
                </ul>
            </td>
            <td>
                <ul>
                    @foreach($post->amenities as $amenity)
                        <li>{{ $amenity->name }}</li>
                    @endforeach
                </ul>
            </td>
            <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</td>
            <td>
                <a href="mailto:{{ $post->user->full_name}}">{{ $post->user->full_name }}</a>
            </td>
            <td>
               <span>
                    @php
                        $ratings = $post->comments->pluck('rating');
                        $averageRating = $ratings->count() > 0 ? number_format($ratings->avg(), 1) : 'Chưa có đánh giá';
                    @endphp
                               {{ $averageRating }}
                </span>
            </td>
            <td>
                <form action="{{ route('admin.updateStatus', $post->id) }}" method="POST">
                    @csrf
                    <select name="approved" onchange="this.form.submit()">
                        <option value="true" {{ $post->approved ? 'selected' : '' }}>Đã Duyệt</option>
                        <option value="false" {{ !$post->approved ? 'selected' : '' }}>Chưa Duyệt</option>
                    </select>
                </form>
            </td>
            <td>
                <form action="{{ route('admin.deletePost', $post->id) }}" method="post" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="delete-button-wrapper">
                        <button type="submit" class="label--1" style="background: none; border: none; cursor: pointer;"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa bài đăng này không?')">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </form>
            </td>
        </tr>
    @endforeach
        @else
            <tr>
                <td colspan="8" class="text-center">Không có bình luận nào!</td>
            </tr>
    @endif
</div>
</body>
</html>
