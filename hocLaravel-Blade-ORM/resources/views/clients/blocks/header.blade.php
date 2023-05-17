<header class="py-3 border shadow p-3 mb-5 bg-body rounded">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h1>
                    <a style="color: inherit; text-decoration:
                   none" href="{{route('home')}}">PhuongLTH</a>
                </h1>
            </div>
            <div class="col-8 d-flex justify-content-end align-items-center">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('home')}}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('product')}}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('posts.index')}}">Bài đăng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tin tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('users.index')}}">Người dùng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
