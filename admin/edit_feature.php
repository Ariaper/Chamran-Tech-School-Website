<?php

include "../configs/session.php";
include "../configs/conf.php";

if (isset($_GET['id'])) {
    $feature_id = $_GET['id'];

    $query_feature = $db->prepare("SELECT * FROM features WHERE id = :id");
    $query_feature->execute(['id' => $feature_id]);

    $feature = $query_feature->fetch();
}

if (isset($_POST['edit'])) {

    if (trim($_POST['Title']) != "" && trim($_POST['Description']) != "") {

        $Title       = $_POST['Title'];
        $Description = $_POST['Description'];


        if (trim($_FILES['Image']['name']) != "") {

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
                header("location:edit_feature.php?failed=فرمت تصویر نادرست است!");
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

            $feature_update = $db->prepare("UPDATE features SET Title = :Title, Description=:Description,  Image=:Image WHERE id=:id");
            $feature_update->execute(['Title' => $Title, 'Description' => $Description, 'Image' => $uniqueImgName, 'id' => $feature_id]);
        } else {
            $feature_update = $db->prepare("UPDATE features SET Title = :Title, Description=:Description WHERE id=:id");
            $feature_update->execute(['Title' => $Title, 'Description' => $Description, 'id' => $feature_id]);
        }
        header("Location:features.php?success=با موفقیت ویرایش شد");
        exit();
    } else {
        header("Location:edit_feature.php?id=$feature_id&failed= تمام فیلد ها الزامی هست");
        exit();
    }
}


include("./includes/header.php");
?>


<!-- html -->

<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            <div class="d-flex justify-content-between mt-5">
                <h3>ویرایش</h3>
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
                    <label for="Title">عنوان</label>
                    <input type="text" class="form-control" name="Title" id="Title"
                        value="<?php echo $feature['Title'] ?>">
                </div>
                <div class="form-group mb-4">
                    <label for="Description">توضیحات</label>
                    <textarea class="form-control" name="Description" id="" cols="30"
                        rows="10"><?= $feature['Description'] ?></textarea>
                </div>
                <img class="img-fluid" src="../image/features/<?php echo $feature['Image'] ?>" alt="" height="400px"
                    width="500px">
                <div class="form-group">
                    <label for="Image">تصویر : </label>
                    <input type="file" class="form-control" name="Image" id="Image">
                </div>
                <button type="submit" name="edit" class="btn btn-outline-primary">ویرایش</button>
            </form>

        </main>

    </div>

</div>

</body>

</html>