<?php
$current_file = substr($_SERVER['SCRIPT_NAME'], 13);
?>

<header class="header_section">
    <div class="header_top">
        <div class="container-fluid">
            <div class="top_nav_container">
                <div class="contact_nav">
                    <a href="">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span>
                            เบอร์โทร : <?= $store->st_phone ?>
                        </span>
                    </a>
                    <a href="">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span>
                            อีเมล : <?= $store->st_email ?>
                        </span>
                    </a>
                </div>
                <from class="search_form">
                    <input type="text" class="form-control" placeholder="Search here...">
                    <button class="" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </from>
                <?php if (isset($_SESSION['CUSTOMER_USERNAME']) && !empty($_SESSION['CUSTOMER_USERNAME'])) : ?>
                    <div class="user_option_box">
                        <a href="" class="account-link">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>
                                บัญชีของฉัน
                            </span>
                        </a>
                        <a href="" class="cart-link">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <span>
                                ตะกร้าสินค้า
                            </span>
                        </a>
                    </div>
                <?php endif ?>
            </div>

        </div>
    </div>
    <div class="header_bottom">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg custom_nav-container ">
                <a class="navbar-brand" href="index.php">
                    <span>
                        <?= $store->st_name ?>
                    </span>
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class=""> </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ">
                        <li class="nav-item <?= ($current_file == 'index.php') ? 'active' : '' ?>">
                            <a class="nav-link" href="index.php">หน้าหลัก <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item <?= ($current_file == 'about.php') ? 'active' : '' ?>">
                            <a class="nav-link" href="about.php">เกี่ยวกับเรา</a>
                        </li>
                        <li class="nav-item <?= ($current_file == 'product.php') ? 'active' : '' ?>">
                            <a class="nav-link" href="product.php">สินค้า</a>
                        </li>
                        <li class="nav-item <?= ($current_file == 'contact.php') ? 'active' : '' ?>">
                            <a class="nav-link" href="contact.php">ติดต่อเรา</a>
                        </li>
                        <?php if (isset($_SESSION['CUSTOMER_USERNAME']) && !empty($_SESSION['CUSTOMER_USERNAME'])) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    สวัสดี, <?= $_SESSION['CUSTOMER_USERNAME'] ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">ข้อมูลส่วนตัว</a>
                                    <a class="dropdown-item" href="#">ประวัติการสั่งของ</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="logout()">ออกจากระบบ</a>
                                </div>
                            </li>
                        <?php else : ?>
                            <li class="nav-item <?= ($current_file == 'login.php' || $current_file == 'register.php') ? 'active' : '' ?>">
                                <a class="nav-link" href="login.php">เข้าสู่ระบบ/ลงทะเบียน</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>