<?php

include "../configs/session.php";
include "../configs/conf.php";
include "./includes/date.php";


if (isset($_POST['insert'])) {


    if (trim($_FILES['Image']['name']) != "") {

        $date = new DateTime();


        //Image checking
        $upload_dir = "../image/gallery/";

        // Get file name, size, type and temporary location
        $file_name = $_FILES["Image"]["name"];
        $file_size = $_FILES["Image"]["size"];
        $file_type = $_FILES["Image"]["type"];
        $file_tmp  = $_FILES["Image"]["tmp_name"];

        // Create a new image from the uploaded file
        $image = null;
        if ($file_type == "image/jpeg") {
            $image = imagecreatefromjpeg($file_tmp);
        } elseif ($file_type == "image/png") {
            $image = imagecreatefrompng($file_tmp);
        } elseif ($file_type == "image/gif") {
            $image = imagecreatefromgif($file_tmp);
        } else {
            header("location:new_image.php?failed=فرمت تصویر نادرست است!");
            exit;
        }


        $exif = @exif_read_data($file_tmp);
        if ($exif !== false) {
            $orientation = isset($exif['Orientation']) ? $exif['Orientation'] : null;
            if ($orientation !== null) {
                $degrees = 0;
                switch ($orientation) {
                    case 3:
                        $degrees = 180;
                        break;
                    case 6:
                        $degrees = -90;
                        break;
                    case 8:
                        $degrees = 90;
                        break;
                }
                if ($degrees != 0) {
                    $image = imagerotate($image, $degrees, 0);
                }
            }
        }

        // Compress and save the image without the metadata
        $file_ext      = pathinfo($file_name, PATHINFO_EXTENSION);
        $uniqueImgName = uniqid() . '.' . $file_ext;
        $file_path     = $upload_dir . $uniqueImgName;
        if ($file_type == "image/jpeg") {
            imagejpeg($image, $file_path, 50); // 80 is the quality of the compressed JPEG image
        } elseif ($file_type == "image/png") {
            imagepng($image, $file_path, 9); // 9 is the compression level of the compressed PNG image
        } elseif ($file_type == "image/gif") {
            imagegif($image, $file_path); // GIF images do not need compression
        }

        //query

        $insert_image = $db->prepare("INSERT INTO gallery (Image, date) VALUES (:image, :date)");
        $insert_image->execute(['image' => $uniqueImgName, 'date' => $formatter->format($date)]);

        header("location:gallery.php?success=عکس با موفقیت افزوده شد!");
        exit();

    } else {
        header("location:new_image.php?failed=تمام فیلد ها الزامی است!");
        exit();
    }
}

include("./includes/header.php");
?>
<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <?php
            if (isset($_GET['failed'])):
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_GET['failed'] ?>
                </div>
            <?php endif; ?>
            <div class="d-flex justify-content-between mt-5">
                <h3>عکس جدید</h3>
            </div>
            <form method="post" class="mb-5" enctype="multipart/form-data">
                <div class="row">

                    <p class="text-warning">فرمت عکس یکی از این 3 تا باشد: jpg, jpeg, png</p>
                    <label for="image">عکس:</label>
                    <input type="file" name="Image">
                </div>

                <input type="submit" name="insert" value="آپلود" class="btn btn-primary">

        </main>

    </div>

</div>