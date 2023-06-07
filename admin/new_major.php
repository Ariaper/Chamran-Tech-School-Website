<?php

include "../configs/session.php";
include "../configs/conf.php";
include "./includes/date.php";

if (isset($_POST['add_major'])) {
    if (trim($_POST['Majorname']) != "" && trim($_POST['Ref']) != "" && trim($_POST['Body']) != "" && trim($_FILES['Image']['name']) != "" && trim($_FILES['Image_detail']['name']) != "") {

        $Majorname  = $_POST['Majorname'];
        $Ref        = $_POST['Ref'];
        $Body       = $_POST['Body'];
        $name_image = $_FILES['Image']['name'];
        $tmp_name   = $_FILES['Image']['tmp_name'];

        $query_checkMajor = $db->prepare("SELECT * FROM majors WHERE Ref = :ref");
        $query_checkMajor->execute(['ref' => $Ref]);

        if ($query_checkMajor->rowCount > 0) {
            header("location:new_major.php?failed=یک رشته با همین نام وجود دارد!");
            exit();
        }

        if (!mb_ereg_match("^[\p{Arabic} ]+$", $Majorname)) {
            header("Location:new_major.php?failed=نام رشته باید فارسی یاشد!");
            exit();
        }
        if (!preg_match("/^[a-zA-Z]+$/", $Ref)) {
            header("Location:new_major.php?failed=مرجع باید نام انگلیسی رشته باشد");
            exit();
        }


        //Image checking
        $upload_dir = "../image/majors/";

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
            header("location:new_major.php?failed=فرمت تصویر نادرست است!");
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


        $imgDetail_name = $_FILES["Image_detail"]["name"];
        $imgDetail_size = $_FILES["Image_detail"]["size"];
        $imgDetail_type = $_FILES["Image_detail"]["type"];
        $imgDetail_tmp  = $_FILES["Image_detail"]["tmp_name"];

        // Create a new image from the uploaded file
        $image = null;
        if ($imgDetail_type == "image/jpeg") {
            $image = imagecreatefromjpeg($imgDetail_tmp);
        } elseif ($imgDetail_type == "image/png") {
            $image = imagecreatefrompng($imgDetail_tmp);
        } elseif ($imgDetail_type == "image/gif") {
            $image = imagecreatefromgif($imgDetail_tmp);
        } else {
            header("location:new_major.php?failed=فرمت تصویر نادرست است!");
            exit;
        }


        $exif = @exif_read_data($imgDetail_tmp);
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
        $file_ext         = pathinfo($imgDetail_name, PATHINFO_EXTENSION);
        $uniqueImgDetName = uniqid() . '.' . $file_ext;
        $file_path        = $upload_dir . $uniqueImgDetName;
        if ($imgDetail_type == "image/jpeg") {
            imagejpeg($image, $file_path, 30); // reduce to 30% 
        } elseif ($imgDetail_type == "image/png") {
            imagepng($image, $file_path, 9); // 9 is the compression level of the compressed PNG image
        } elseif ($imgDetail_type == "image/gif") {
            imagegif($image, $file_path); // GIF images do not need compression
        }

        //INSERT into db
        $major_insert = $db->prepare("INSERT INTO majors (Majorname, Ref, Body,  Image, Image_detail) VALUES (:Majorname , :Ref , :Body, :Image, :Image_detail)");
        $major_insert->execute(['Majorname' => $Majorname, 'Ref' => $Ref, 'Body' => $Body, 'Image' => $uniqueImgName, 'Image_detail' => $uniqueImgDetName]);
        header("Location:majors.php?success=رشته با موفقیت افزوده شد!");
        exit();
    } else {
        header("Location:new_major.php?failed= تمام فیلد ها الزامی هست");
        exit();
    }
}

include("./includes/header.php");
?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/translations/ar.js"></script>
<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            <div class="d-flex justify-content-between mt-5">
                <h3>افزودن رشته</h3>
            </div>
            <hr>
            <?php
            if (isset($_GET['failed'])):
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['failed'] ?>
                </div>
                <?php
            endif;
            ?>
            <form method="post" class="mb-5" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Majorname">نام رشته:</label>
                    <input type="text" class="form-control" name="Majorname" id="Majorname">
                    <p class="text-warning">نام رشته را فارسی وارد کنید</p>
                </div>
                <div class="form-group">
                    <label for="Ref">مرجع (نام انگلیسی رشته) :</label>
                    <input type="text" class="form-control" name="Ref" id="Ref">
                    <p class="text-warning">مرجع حتما انگلیسی باشد</p>

                </div>
                <div class="form-group">
                    <label for="category">توضیحات رشته : </label>
                    <textarea class="form-control" name="Body" id="Body" rows="3">
                    </textarea>
                </div>
                <script>
                    ClassicEditor
                        .create(document.querySelector('#Body'), {
                            language: {

                                ui: 'en',


                                content: 'ar'
                            }
                        })
                        .then(editor => {
                            window.editor = editor;
                        })
                        .catch(err => {
                            console.error(err.stack);
                        });
                </script>

                <div class="form-group">
                    <label for="Image">تصویر : </label>
                    <input type="file" class="form-control" name="Image" id="Image">
                    <p class="text-warning">تصاویر با فرمت jpg, png, gif قابل قبول است</p>
                </div>
                <div class="form-group">
                    <label for="Image_detail">کارگاه یا توضیحی تصویر : </label>
                    <input type="file" class="form-control" name="Image_detail" id="Image_detail">
                    <small class="form-text text-muted">تصویر را وارد کنید.</small>
                </div>
                <button type="submit" name="add_major" class="btn btn-outline-primary">افزودن</button>
            </form>

        </main>

    </div>

</div>

</body>

</html>