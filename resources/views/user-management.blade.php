<!DOCTYPE html>
html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lí Người Dùng</title>
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
  <link rel="stylesheet" href="@{/css/management.css}">
</head>
<body>
<header class="header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="inner-head">
          <div class="inner-logo">
            <a href="@{/admin/home}">
              <img src="/image/logo.png" alt="logo">
            </a>
          </div>
          <div class="inner-menu">
            <ul class="menu">
              <li><a href="/admin/home" class="active-menu">Trang Chủ</a></li>
              <li><a href="/admin/user-management">Quản Lí Người Dùng</a></li>
              <li><a href="/admin/post-management">Quản Lí Bài Đăng</a></li>
              <li><a href="/admin/comment-management">Quản Lí Bình Luận</a></li>
            </ul>
          </div>
          <div class="user-dropdown">
            <div class="dropdown-toggle">
              <i class="fa-solid fa-user"></i>
              <span text="${email}"></span>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="dropdown-menu">
              <li><a href="/admin/profile">Quản Lí Cá Nhân</a></li>
              <li><form action="/logout" method="post">
                <button type="submit">Đăng Xuất</button>
              </form></li>
            </ul>
          </div>
          <div class="inner-menu-mb">
            <div class="menu-mb-icon"><i class="fa-solid fa-bars"></i></div>
            <ul class="menu-mb">
              <li><a href="/admin/home" class="active-menu"><i class="fa-solid fa-house"></i>Trang Chủ</a></li>
              <li><a href="/admin/user-management"><i class="fa-solid fa-house"></i>Quản Lí Người Dùng</a></li>
              <li><a href="/admin/post-management"><i class="fa-solid fa-house"></i>Quản Lí Bài Đăng</a></li>
              <li><a href="/admin/comment-management"><i class="fa-solid fa-house"></i>Quản Lí Bình Luận</a></li>
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
<div class="style-body" style="overflow-x: auto;">
  <h1>Danh sách người dùng</h1>
  <table border="1">
    <thead>
    <tr>
      <th>Email</th>
      <th>Số Điện Thoại</th>
      <th>Ngày Bắt Đầu</th>
      <th>Ngày Cập Nhật</th>
      <th>Bài Đăng</th>
      <th>Bình Luận</th>
    </tr>
    </thead>
    <tbody>
    <tr ="user : ${users}">
      <td>
        <a href="mailto:${user.email}" text="${user.email}"></a>
      </td>
      <td text="${user.phone}"></td>
      <td text="${#dates.format(user.created, 'dd/MM/yyyy HH:mm')}"></td>
      <td text="${#dates.format(user.updated, 'dd/MM/yyyy HH:mm')}"></td>
      <td>
        <ul>
          <li ="post : ${user.listPost}" text="${post.title}">
          </li>
        </ul>
      </td>
      <td>
        <ul>
          <li ="comment : ${user.listComment}" text="${comment.content}">Amenity</li>
        </ul>
      </td>
      <td>
        <form action="@{/admin/user-management/{id}(id=${user.id})}" method="post" id="deleteForm">
          <input type="hidden" name="_method" value="delete">
          <div class="delete-button-wrapper">
            <button type="submit" class="label--1" style="background: none; border: none; cursor: pointer;"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">
              <i class="fa-solid fa-trash-can"></i>
            </button>
          </div>
        </form>
      </td>
    </tr>
    </tbody>
  </table>
</div>
</body>
</html>
