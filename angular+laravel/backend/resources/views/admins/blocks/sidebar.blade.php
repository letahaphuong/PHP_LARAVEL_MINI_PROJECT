<div class="wrapper d-flex align-items-stretch vh-100 sticky-top" style="background: #212121">
    <nav id="sidebar">
        <div class="custom-menu">
            <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
            </button>
        </div>
        <h1><a href="#" class="logo">PhuongLTH Billiard</a></h1>
        <ul class="list-unstyled components mb-5">
            <li class="active">
                <a href="{{route('billiard.home')}}"><span class="fa fa-home mr-3"></span> Trang Chủ</a>
            </li>
            <li>
                <a href="{{route('billiard.dashboard')}}"><span class="fa fa-user mr-3"></span> Lịch Sử</a>
            </li>
            <li>
                <a href="{{route('billiard.index')}}"><span class="fa fa-list" aria-hidden="true"></span>&emsp; Danh sách bàn</a>
            </li>
            <li>
                <a href="{{route('billiard.products-management')}}"><span class="fa fa-list-alt" aria-hidden="true"></span>&emsp; Quản Lý Danh Mục</a>
            </li>
            <li>
                <a href="#"><span class="fa fa-address-card" aria-hidden="true"></span>&emsp; Quản Lý Thành Viên</a>
            </li>
            <li>
                <a href="#"><span class="fa fa-paper-plane mr-3"></span> Thông Tin Khác</a>
            </li>
        </ul>
    </nav>
</div>
