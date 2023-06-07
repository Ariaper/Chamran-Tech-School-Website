<?php

include "../configs/session.php";
include "../configs/conf.php";

if (isset($_POST['add'])) {
    if (trim($_POST['Title']) != "" && trim($_POST['Description']) != "" && trim($_FILES['Image']['name']) != "") {


        $Title       = $_POST['Title'];
        $Description = $_POST['Description'];


        //Image checking
        $upload_dir = "../image/features/";

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
            header("location:new_feature.php?failed=فرمت تصویر نادرست است!");
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
            imagejpeg($image, $file_path, 30); // 80 is the quality of the compressed JPEG image
        } elseif ($file_type == "image/png") {
            imagepng($image, $file_path, 9); // 9 is the compression level of the compressed PNG image
        } elseif ($file_type == "image/gif") {
            imagegif($image, $file_path); // GIF images do not need compression
        }


        $teacher_insert = $db->prepare("INSERT INTO features (Title, Description, Image) VALUES (:Title , :Description , :Image)");
        $teacher_insert->execute(['Title' => $Title, 'Description' => $Description, 'Image' => $uniqueImgName]);

        header("Location:features.php?success= با موفقیت افزوده شد!");
        exit();
    } else {
        header("Location:new_feature.php?failed= تمام فیلد ها الزامی هست");
        exit();
    }
}
include("./includes/header.php");

?>

<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            <div class="d-flex justify-content-between mt-5">
                <h3>افزودن</h3>
            </div>

            <hr>
            <?php
            if (isset($_GET['failed'])) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['failed'] ?>
                </div>
                <?php
            }
            ?>
            <form method="post" class="mb-5" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Title">عنوان:</label>
                    <input type="text" class="form-control" name="Title" id="Title" maxlength="40">
                </div>
                <div class="form-group">
                    <label for="Description">توضیحات</label>
                    <textarea class="form-control" name="Description" id="Description" maxlength="150">
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="Image">تصویر : </label>
                    <input type="file" class="form-control" name="Image" id="Image">
                </div>

                <button type="submit" name="add" class="btn btn-outline-primary">افزودن</button>
            </form>

        </main>

    </div>

</div>

</body>