<?php

$errorFields = [];

$categoryQuery = $conn->query("SELECT * FROM category ORDER BY id ASC");
$categories = $categoryQuery->fetch_all(MYSQLI_ASSOC);
?>
<header class="header">
    <div class="header__first">
        <div class="container">

            <div class="header__first-navbar">
                <div class="mobile-menu">
                    <button class="navbar-toggler" type="button" id="show-menu" aria-label="Toggle navigation" style="border: none; color: white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="bi" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
                        </svg>
                    </button>
                    <div class="account container-xxl">
                        <div class="overlay"></div>
                        <div class="account-user collapse-box" id="mobileNav">
                            <div class="container">
                                <div class="header-box">
                                    <h3 style="line-height: 40px; color: #333333; font-size: 22px; font-weight: 400; padding: 0 6px" class="heading">MENU</h3>
                                    <button style="font-size: 18px;" type="button" class="btn-close" id="close-menu"></button>
                                </div>
                                <ul>
                                    <li><a href="/">Trang chủ</a></li>
                                    <li><a href="">Giới thiệu</a></li>
                                    <li class="item">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#">Phân loại</a>
                                            <ul class="dropdown-menu">
                                                <?php 
                                                    foreach($categories as $category) {
                                                        echo '<li><a class="dropdown-item" href="/product-list?id='. $category['id'].'"> ' . $category['name'] .'</a></li>';
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="" class="" id="contactLink1">Liên hệ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header__first-navbar-logo" style="text-align: center;">
                        <h1 class="header__first-navbar-brand">VND</h1>
                        <h4 class="header__first-navbar-discription">Discover Your Uniqueness</h4>
            </div>
            <ul class="header__first-navbar-list-icon" style="cursor: pointer;">
                    <li class="header__first-navbar-item item1" >
                        <div href="" class="header__first-navbar-item-link" >
                            <i id="searchBtn" class="header__first-navbar-icon bi bi-search"></i>
                            <div class="searchBox" style="display: none;">
                                <form id="basicSearchForm" class="d-flex align-items-center" style="gap: 8px;">
                                    <input type="text" id="basicSearchInput" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                                    <button type="submit" style="font-size: 14px;" class="btn  btn-link btn-search">Tìm</button>
                                    <button type="button" style="font-size: 14px; width: 124px;" id="toggleAdvancedSearch" class="btn btn-outline-primary">Nâng cao</button>
                                </form>
                                <form id="advancedSearchForm" style="display: none; margin-top: 10px;">
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <select id="categorySelect" class="form-select">
                                                <option value="">Phân loại</option>
                                                 <?php 
                                                    foreach($categories as $category) {
                                                        echo '<option value="'. $category['id'] .'">' . $category['name'] .'</option>';
                                                    }
                                                ?>
                    
                                            </select>
                                        </div>
                                        <div class="col-md-3 d-flex align-items-center">
                                            <input type="number" id="minPrice" class="form-control" placeholder="Giá từ">
                                            <span style="margin: 0 5px;">-</span>
                                            <input type="number" id="maxPrice" class="form-control" placeholder="Giá đến">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-link btn-search w-100">Tìm kiếm nâng cao</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>  
                    </li>

                    <li class="header__first-navbar-item item2" style="border-right: 1px solid var(--white-color);">
                        <a href="/shoppingcart" class="header__first-navbar-item-link" >
                            <i class="header__first-navbar-icon bi bi-cart2"></i>
                        </a>
                    </li>
                    <li class="header__first-navbar-item item3">
                        <div href="" class="header__first-navbar-item-link">
                            <i class="header__first-navbar-icon bi bi-person-circle" id="accountBtn"></i>

                            <div class="header__first-navbar-item-account had-account" id="accountBox-had">
                                <ul>
                                    <li id="button-inf" onclick="displayInfUser()">
                                        <i class="header__first-navbar-icon bi bi-person-circle"></i>
                                        <p >Thông tin khách hàng</p>
                                    </li>
                                    <!-- Modal -->
                                    <div id="box-inf">
                                        
                                    </div>
                                        

                                    <li>
                                        <i class="header__first-navbar-icon bi bi-cart2"></i>
                                        <a href="/history">Lịch sử mua hàng</a>
                                    </li>
                                    <li id="logout">
                                        <i  class=" header__first-navbar-icon bi bi-box-arrow-right"></i>
                                        <p >Đăng xuất</p>
                                    </li>
                                </ul>
                            </div>

                            <div class="header__first-navbar-item-account no-account" id="accountBox-no">
                                <ul>
                                    <li>
                                        <a href="/login">Đăng nhập</a>
                                    </li>
                                    <li>
                                        <a href="/signup">Đăng ký</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
            </ul>
        </div>
    </div>
    
    <div class="main-menu header__second">

        <nav class="navbar navbar-expand-md bg-body-tertiary header__second-navbar">
            <div class="container-fluid" style="height: 100%;">
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="height: 100%;">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 header__second-navbar-list" style="    margin: 0;
width: 100%;">
                    <li class="nav-item header__second-navbar-item">
                    <a class="nav-link header__second-navbar-link" aria-current="page" href="/">TRANG CHỦ</a>
                    </li>
                    <li class="nav-item header__second-navbar-item" style="cursor: default;">
                    <a class="nav-link header__second-navbar-link  " href="#aboutUs" id="aboutUsLink">GIỚI THIỆU</a>
                    </li>
                    <li class="nav-item header__second-navbar-item">
                    <a class="header__second-navbar-link" >
                        PHÂN LOẠI
                            <i class="header__second-navbar-link-icon bi bi-chevron-compact-down"></i>
                            <div class="header__second-navbarsub ">
                                <ul>
                                    <?php 
                                    foreach($categories as $category) {
                                        echo '<li>
                                            <a href="/product-list?id='. $category['id'] .'" class="disabled">
                                                <p>'. $category['name'] .'</p>
                                            </a>
                                        </li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                    </a>
                    </li>
                    <li class="nav-item header__second-navbar-item" style="border: none ;cursor: default;">
                    <a class="nav-link header__second-navbar-link  "  href="" id="contactLink">LIÊN HỆ</a>
                    </li>
                </ul>
                </div>
            </div>
            </nav>
    </div>

</header>
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <span class="close" style="position: absolute; top: 0;right: 0; cursor: pointer;font-size: 30px;padding: 0 20px;">&times;</span>
            <h2 style="text-align: center; margin-bottom: 20px;">Thông Tin Liên Hệ</h2>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Điện thoại: (+84) 0123456789</span>
                </div>
                <div class="contact-item">
                    <i class="bi bi-envelope-fill"></i>
                    <span>Email: vndperfume@gmail.com</span>
                </div>
                <div class="contact-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Địa chỉ: 273 An Dương Vương, P3, Q5, TP HCM</span>
                </div>
                <div class="contact-item">
                    <i class="bi bi-clock-fill"></i>
                    <span>Giờ làm việc: 8:00 - 22:00 (Thứ 2 - Chủ nhật)</span>
                </div>
            </div>
        </div>
    </div>
    <script src="./app/assets/js/header.js"></script>