<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Hồ Sơ Cá Nhân</title>
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
    <link rel="stylesheet" href="/css/post.css">
    <link rel="stylesheet" href="@{/css/postdetail.css}">
    <link rel="stylesheet" href="@{/css/profile.css}">
</head>
<body>
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="inner-head">
                    <div class="inner-logo">
                        <a href="/user/home">
                            <img src="/image/logo.png" alt="logo">
                        </a>
                    </div>
                    <div class="inner-menu">
                        <ul class="menu">
                            <li><a href="/user/home" class="active-menu">Trang Chủ</a></li>
                            <li><a href="/introduce">Giới Thiệu</a></li>
                            <li><a href="/post">Bài Đăng</a></li>
                            <li><a href="/contact">Liên Hệ</a></li>
                        </ul>
                    </div>
                    <div class="user-dropdown">
                        <div class="dropdown-toggle">
                            <i class="fa-solid fa-user"></i>
                            <span text="${user.email}">Tên Người Dùng</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a href="/user/profile">Quản Lí Cá Nhân</a></li>
                            <li><form action="/logout" method="post">
                                <button type="submit">Đăng Xuất</button>
                            </form></li>
                        </ul>
                    </div>

                    <div class="inner-menu-mb">
                        <div class="menu-mb-icon"><i class="fa-solid fa-bars"></i></div>
                        <ul class="menu-mb">
                            <li><a href="/user/home" class="active-menu"><i class="fa-solid fa-house"></i>Trang Chủ</a></li>
                            <li><a href="/introduce"><i class="fa-solid fa-house"></i>Giới Thiệu</a></li>
                            <li><a href="/post"><i class="fa-solid fa-house"></i>Bài Đăng</a></li>
                            <li><a href="/contact"><i class="fa-solid fa-house"></i>Liên Hệ</a></li>
                            <li class="item-action">
                                <a href="/login">Đăng Nhập</a>
                                <a href="/logout">Đăng Xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
<div class="profile-container">
    <div class="profile-header">
        <i class="fa-solid fa-user-circle" style="font-size: 50px;"></i>
        <h2>Hồ Sơ Cá Nhân</h2>
    </div>
    <div class="profile-info">
        <label for="email">Email:</label>
        <p id="email" text="${user.email}"></p>

        <label for="fullName">Họ Tên:</label>
        <p id="fullName" text="${user.fullName}"></p>

        <label for="phone">Số Điện Thoại:</label>
        <p id="phone" text="${user.phone}"></p>

        <a href="javascript:void(0);" class="btn-edit-profile" onclick="editProfile()">
            <i class="fa-solid fa-pen"></i>
        </a>
    </div>
    <div id="editForm" style="display: none;">
        <form action="@{/user/profile/updateProfile}" method="post" th:object="${user}">
            <div class="form-group">
                <label for="fullNameEdit">Họ Tên:</label>
                <input type="text" id="fullNameEdit" th:field="*{fullName}" value="${user.fullName}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phoneEdit">Số Điện Thoại:</label>
                <input type="text" id="phoneEdit" th:field="*{phone}" value="${user.phone}" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Hủy</button>
            </div>
        </form>
    </div>
    <div class="post-container">
        <label>Danh Sách Bài Đăng Của Bạn</label>
        <div class="row">
            <div class="col-md-6 col-12" ="post : ${posts}">
                <div class="inner-box">
                    <div class="inner-img" th:if="${post.listImages != null and !post.listImages.isEmpty()}">
                        <img src="@{'/' + ${post.listImages[0].url}}" alt="Image Description" class="image" />
                    </div>
                    <div class="inner-content">
                        <h3 class="title" text="${post.title}"></h3>
                        <a th:if="${post.location.link}" href="${post.location.link}" target="_blank" class="btn inner-location">
                            <i class="fa-solid fa-map-location"></i>
                            <p class="line-clamp" style="--line-clamp:1;" text="${post.location.address}"></p>
                        </a>
                        <div class="inner-bot">
                            <p class="inner-price" text="${post.price}"></p>
                            <a href="@{/post/detail/{id}(id=${post.id})}" class="btn">Xem Phòng</a>
                            <form action="@{/user/profle/updatePost/{id}(id=${post.id})}" method="post" onsubmit="return confirm('Bạn chắc chắn muốn xóa bài đăng này?');">
                                <button type="submit" class="btn btn-danger">Xóa Bài</button>
                            </form>
                        </div>
                        <div>
                            <p class="post-status" text="${post.approved ? 'Đã được duyệt' : 'Chưa được duyệt'}"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="comment">
        <label>Danh Sách Bình Luận Của Bạn</label>
            <ul class="comments-list" ="comment : ${comments}">
                <li class="comment-item">
                    <div class="comment-rating">
                        <span ="i : ${#numbers.sequence(0, 4)}">
                            <i class="fa-star" th:class="${i < comment.rating ? 'fas fa-star' : 'far fa-star'}"></i>
                        </span>
                    <div class="comment-content">
                        <p text="${comment.content}"></p>
                        <a href="@{/post/detail/{id}(id=${comment.post.id})}" class="btn">Xem Bình Luận</a>
                        <span text="${comment.approved ? 'Đã Được Duyệt' : 'Chưa Được Duyệt'}" class="comment-status"></span>
                    </div>
                    </div>
                </li>
            </ul>
    </div>
</div>
</div>
<script>
    function editProfile() {
        console.log("Chỉnh sửa profile");
        document.querySelector('.profile-info').style.display = 'none';
        document.getElementById('editForm').style.display = 'block';
    }
    function cancelEdit() {
        document.querySelector('.profile-info').style.display = 'block';
        document.getElementById('editForm').style.display = 'none';
    }
</script>
</body>
</html>
