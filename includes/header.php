<!DOCTYPE html>
<html dir="rtl" lang="fa">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="preconnect" href="//fdn.fontcdn.ir">
    <link rel="preconnect" href="//v1.fontapi.ir">
    <link href="https://v1.fontapi.ir/css/Vazir" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>هنرستان فنی شهید چمران</title>
</head>

<body>
    <!-- <div class="loader">
        <img src="image/rowloader.gif" alt="Loading..." />
    </div> -->
    <header class="shadow">
        <nav class="navbar navbar-expand-lg navbar-light fw-bold" id="navdark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img src="https://s6.uupload.ir/files/chamran1_8x7t.jpg"
                        style="height: 65px" alt="" />
                    هنرستان فنی چمران
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">صفحه اصلی</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="all_announce.php">تابلو اعلانات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gallery.php">گالری تصاویر</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#contactus">تماس با ما</a>
                        </li>
                        <?php
                        session_start();
                        if (isset($_SESSION["state_login"])):
                            ?>
                            <li class="nav-item ">
                                <a class="nav-link" href="admin">مدیریت</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="admin/logout.php">خروج</a>
                            </li>
                            <?php
                        else:
                            ?>
                            <li id="login-item" class="nav-item ">
                                <a class="nav-link" href="admin">ورود مدیر</a>
                            </li>
                            <?php
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>