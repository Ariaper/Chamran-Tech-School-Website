<?php
include "../configs/session.php";
include "../configs/conf.php";



if (isset($_POST['edit_banner'])) {

    $query_banner = $db->prepare("SELECT id FROM banner");
    $query_banner->execute();

    $id = $query_banner->fetch()['id'];

    if (trim($_FILES['Image']['name']) != "") {

        //Image checking
        $upload_dir = "../image/banner/";

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
            header("location:banner.php?failed=فرمت تصویر نادرست است!");
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
            imagejpeg($image, $file_path, 80); // 80 is the quality of the compressed JPEG image
        } elseif ($file_type == "image/png") {
            imagepng($image, $file_path, 9); // 9 is the compression level of the compressed PNG image
        } elseif ($file_type == "image/gif") {
            imagegif($image, $file_path); // GIF images do not need compression
        }

        $submit_banner = $db->prepare("UPDATE banner SET banner = :banner WHERE id = :id");
        $submit_banner->execute(['banner' => $uniqueImgName, 'id' => $id]);

        header("location:banner.php?success=با موفقیت ثبت شد!");
        exit();
    } else {
        header("location:banner.php?success=با موفقیت ثبت شد!");
        exit();
    }

}

include "includes/header.php";
?>
<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            <div class="d-flex justify-content-between mt-5">
                <h4>تصویر بنر</h4>


            </div>
            <div class="col-md-6">
                <div class="container mt-1">
                    <?php
                    $query_getbanner = $db->prepare("SELECT * FROM banner");
                    $query_getbanner->execute();

                    ?>
                    <img src="../image/banner/<?= $query_getbanner->fetch()['banner'] ?>" alt=""
                        class="rounded d-block w-100">
                </div>
            </div>
            <hr>
            <h3>بارگذاری بنر جدید</h3>
            <form method="post" class="mb-5" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Image">تصویر : </label>
                    <input type="file" class="form-control" name="Image" id="Image">
                </div>
                <button type="submit" name="edit_banner" class="btn btn-outline-primary">بارگذاری</button>
            </form>


        </main>

    </div>

</div>


</body>

</html>