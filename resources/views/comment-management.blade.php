<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org">
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
                <a href="{{route('login')}}">Đăng Nhập</a>
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
  <h1>Danh sách bình luận</h1>
  <table border="1">
    <thead>
    <tr>
      <th>Nội Dung</th>
      <th>Đánh Giá</th>
      <th>Ngày Đăng</th>
      <th>Bài Đăng</th>
      <th>Người Dùng</th>
      <th>Tình Trạng</th>
    </tr>
    </thead>
    <tbody>
    <tr ="comment : ${comments}">
      <td text="${comment.content}"></td>
      <td text="${comment.rating}"></td>
      <td text="${#dates.format(comment.created, 'dd/MM/yyyy HH:mm')}"></td>
      <td text="${comment.post.title}"></td>
      <td>
        <a href="mailto:${comment.user.email}" text="${comment.user.email}"></a>
      </td>
      <td>
        <form action="@{/admin/comment-management/updateStatus}" method="post">
          <input type="hidden" th:name="commentId" th:value="${comment.id}" />
          <select name="approved" onchange="this.form.submit()">
            <option value="true" th:selected="${comment.approved}">Đã Duyệt</option>
            <option value="false" th:selected="${!comment.approved}">Chưa Duyệt</option>
          </select>
        </form>
      </td>
      <td>
        <form action="@{/admin/comment-management/{id}(id=${comment.id})}" method="post" id="deleteForm">
          <input type="hidden" name="_method" value="delete">
          <div class="delete-button-wrapper">
            <button type="submit" class="label--1" style="background: none; border: none; cursor: pointer;"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này này không?')">
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
