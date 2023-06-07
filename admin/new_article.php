<?php

include "../configs/session.php";
include "../configs/conf.php";
include "./includes/date.php";


if (isset($_POST['add'])) {
    if (trim($_POST['Title']) != "" && trim($_POST['Author']) != "" && trim($_POST['Description']) != "" && trim($_FILES['Image']['name']) != "") {

        $initdate = new DateTime();

        $Title       = $_POST['Title'];
        $Author      = $_POST['Author'];
        $Description = $_POST['Description'];

        $date = $formatter->format($initdate);


        //Image checking
        $upload_dir = "../image/articles/";

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
            header("location:new_article.php?failed=فرمت تصویر نادرست است!");
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


        //INSERT into db
        $major_insert = $db->prepare("INSERT INTO articles (Title, Author, Image, Description, date) VALUES (:Title , :Author , :Image, :Description, :date)");
        $major_insert->execute(['Title' => $Title, 'Author' => $Author, 'Image' => $uniqueImgName, 'Description' => $Description, 'date' => $date]);
        header("Location:articles.php?success=خبر با موفقیت افزوده شد!");
        exit();
    } else {
        header("Location:new_article.php?failed= تمام فیلد ها الزامی هست");
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
                <h3>افزودن خبر</h3>
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
                    <label for="Title">عنوان:</label>
                    <input type="text" class="form-control" name="Title" id="Title">
                </div>
                <div class="form-group">
                    <label for="Author">نویسنده:</label>
                    <input type="text" class="form-control" name="Author" id="Author">
                </div>
                <div class="form-group">
                    <label for="Description">متن:</label>
                    <textarea class="form-control" name="Description" id="Description">
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="Image">تصویر:</label>
                    <input type="file" class="form-control" name="Image" id="Image">
                    <p class="text-warning">تصاویر با فرمت jpg, png, gif قابل قبول است</p>
                </div>
                <button type="submit" name="add" class="btn btn-outline-primary">افزودن</button>
            </form>

        </main>

    </div>

</div>

<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('Description', {
        language: 'ar',
        contentsLangDirection: 'rtl',
        toolbar: [
            { name: 'basicstyles', items: ['Bold'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Header', 'Paragraph'] },
            { name: 'editing', items: ['Undo', 'Redo'] }
        ]
    });
</script>

</body>

</html>