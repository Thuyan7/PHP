<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Bài Đăng</title>
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
    <link rel="stylesheet" href="/css/create-post.css">
</head>
<body>
<div class="header-1">
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="inner-head">
                        <div class="inner-logo">
                            <a href="{{route ('user.home')}}" >
                                <img src="/image/logo.png" alt="logo">
                            </a>
                        </div>
                        <div class="inner-menu">
                            <ul class="menu">
                                <li><a href="{{route ('user.home')}}" class="active-menu">Trang Chủ</a></li>
                                <li><a href="{{route ('introduce')}}" class="active-menu">Giới Thiệu</a></li>
                                <li><a href="{{route('post')}}" class="active-menu">Bài Đăng</a></li>
                                <li><a href="{{route ('contact')}}" class="active-menu">Liên Hệ</a></li>
                            </ul>
                        </div>
                        <div class="user-dropdown">
                            <div class="dropdown-toggle">
                                <i class="fa-solid fa-user"></i>
                                <span>{{ $user->full_name }}</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <ul class="dropdown-menu">
                                <li><a href="{{route ('user.profile')}}">Quản Lí Cá Nhân</a></li>
                                <li><a href="{{route('logout')}}">Đăng Xuất</a></li>
                            </ul>
                        </div>
                        <div class="inner-menu-mb">
                            <div class="menu-mb-icon"><i class="fa-solid fa-bars"></i></div>
                            <ul class="menu-mb">
                                <li><a href="{{route ('user.home')}}" class="active-menu"><i class="fa-solid fa-house"></i>Trang Chủ</a></li>
                                <li><a href="{{route ('introduce')}}"><i class="fa-solid fa-house"></i>Giới Thiệu</a></li>
                                <li><a href="{{route('post')}}"><i class="fa-solid fa-house"></i>Bài Đăng</a></li>
                                <li><a href="{{route ('contact')}}"><i class="fa-solid fa-house"></i>Liên Hệ</a></li>
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
</div>

<div class="container mt-5">
    <div class="post">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('user.updatePost',$post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="image-1 mb-3">
                        <div class="img-wrap" id="imgWrap">
                            @foreach ($post->listImages as $image)
                                <div class="img-container" style="display: inline-block; margin-right: 10px;">
                                    <img src="{{ asset('storage/' . $image->url) }}" alt="Image" style="max-width: 150px; max-height: 150px;">
                                </div>
                            @endforeach
                        </div>
                        <div class="image-upload">
                            <label class="label-1" for="images">
                                <i class="fa-solid fa-file-arrow-up"></i> Tải lên hình ảnh
                            </label>
                            <input type="file" name="images[]" id="images" hidden multiple>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="post-content mb-3">
                        <label class="label-1" for="title">Tiêu Đề:</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" class="form-control" placeholder="Tiêu đề ">
                    </div>

                    <div class="price mb-3">
                        <label class="label-1" for="price">Giá:</label>
                        <input type="text" id="price" name="price" value="{{old('price', $post->price)}}" class="form-control" placeholder="Giá">
                    </div>

                    <div class="description mb-3">
                        <label class="label-1" for="description">Miêu tả:</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Miêu tả"
                                  rows="3" required>{{old('description', $post->description)}}</textarea>
                    </div>
                    <div class="address mb-3">
                        <label class="label-1" for="address">Địa Chỉ:</label>
                        <input type="text" id="address" name="address" value="{{old('address',$post->location->address)}}" class="form-control" placeholder="Địa Chỉ" >
                    </div>
                    <div class="amenities mb-3" style="color: black">
                        <label for="amenities">Tiện ích:</label>
                        <div>
                            @foreach ($amenities as $amenity)
                                <label>
                                    <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                        {{ in_array($amenity->id, $post->amenities->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    {{ $amenity->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="submit-button">
                        <button type="submit" class="btn btn-primary">Cập Nhật Bài Đăng</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="/js/create-post.js"></script>
</body>
</html>
