<?php

include "../configs/session.php";
include "../configs/conf.php";
include "./includes/date.php";

include("./includes/header.php");
?>

<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">داشبورد</h1>
            </div>
            <?php
            $initdate = new DateTime();
            ?>
            <p class="text-primary">تاریخ و ساعت:
                <?= $formatter->format($initdate); ?>
            </p>
            <div class="row text-center">

                <div class="col-2 m-2 rounded border dashboard-grid">
                    <a href="majors.php" class="text-decoration-none dashboard-link text-white">
                        <i class="bi bi-book" style="font-size: 2rem;"></i>
                        رشته ها
                    </a>
                </div>
                <div class="col-2 m-2 rounded border dashboard-grid">
                    <a href="books.php" class="text-decoration-none dashboard-link text-white">
                        <i class="bi bi-book" style="font-size: 2rem;"></i>
                        کتاب ها
                    </a>
                </div>
                <div class="col-2 m-2 rounded border dashboard-grid">
                    <a href="teachers.php" class="text-decoration-none dashboard-link text-white">
                        <i class="bi bi-person" style="font-size: 2rem;"></i>
                        هنرآموزان
                    </a>
                </div>
                <div class="col-2 m-2 rounded border dashboard-grid">
                    <a href="features.php" class="text-decoration-none dashboard-link text-white">
                        <i class="bi bi-layers" style="font-size: 2rem;"></i>
                        امکانات
                    </a>
                </div>
                <div class="col-2 m-2 rounded border dashboard-grid">
                    <a href="cadre.php" class="text-decoration-none dashboard-link text-white">
                        <i class="bi bi-person-vcard-fill" style="font-size: 2rem;"></i>
                        کادر مدرسه
                    </a>
                </div>
                <div class="col-2 m-2 rounded border dashboard-grid">
                    <a href="rules.php" class="text-decoration-none dashboard-link text-white">
                        <i class="bi bi-chat-left-text-fill" style="font-size: 2rem;"></i>
                        قوانین
                    </a>
                </div>
                <div class="col-2 m-2 rounded border dashboard-grid">
                    <a href="gallery.php" class="text-decoration-none dashboard-link text-white">
                        <i class="bi bi-images" style="font-size: 2rem;"></i>
                        گالری تصاویر
                    </a>
                </div>
                <div class="col-2 m-2 rounded border dashboard-grid">
                    <a href="announcements.php" class="text-decoration-none dashboard-link text-white">
                        <i class="bi bi-megaphone" style="font-size: 2rem;"></i>
                        تابلو اعلانات
                    </a>
                </div>
            </div>
        </main>
    </div>

</div>