<?php

include "../configs/session.php";
include "../configs/conf.php";
if (isset($_POST['add_teacher'])) {
    if (trim($_POST['Nameandlastname']) != "" && trim($_POST['Degree']) != "" && trim($_POST['teacherMajor']) != "" && trim($_FILES['Image']['name']) != "") {


        $Nameandlastname = $_POST['Nameandlastname'];
        $Degree          = $_POST['Degree'];
        $teacherMajor    = $_POST['teacherMajor'];


        //Image checking
        $upload_dir = "../image/teachers/";

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
            header("location:new_teacher.php?failed=فرمت تصویر نادرست است!");
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


        $teacher_insert = $db->prepare("INSERT INTO teachers (Nameandlastname, Degree, Major_id, Image) VALUES (:Nameandlastname , :Degree , :Major_id, :Image)");
        $teacher_insert->execute(['Nameandlastname' => $Nameandlastname, 'Degree' => $Degree, 'Major_id' => $teacherMajor, 'Image' => $uniqueImgName]);

        header("Location:teachers.php?success=هنرآموز با موفقیت افزوده شد!");
        exit();
    } else {
        header("Location:new_teacher.php?failed= تمام فیلد ها الزامی هست");
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
                <h3>افزودن هنرآموز</h3>
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
                    <label for="Nameandlastname">نام و نام خانوادگی هنرآموز :</label>
                    <input type="text" class="form-control" name="Nameandlastname" id="Nameandlastname" maxlength="40">
                    <small class="form-text text-muted">نام و نام خانوادگی هنرآموز را وارد کنید</small>
                </div>
                <div class="form-group">
                    <label for="Degree">تحصیلات :</label>
                    <input type="text" class="form-control" name="Degree" id="Degree" maxlength="40">
                    <small class="form-text text-muted">تحصیلات هنرآموز را وارد کنید</small>
                </div>
                <div class="form-group">
                    <label for="teacherMajor"> رشته مربوطه :</label>
                    <select class="form-control" name="teacherMajor" id="teacherMajor">
                        <?php
                        $query_majors = $db->prepare("SELECT * FROM majors");
                        $query_majors->execute();
                        if ($query_majors->rowCount() > 0) {
                            ?>
                            <option value="">-انتخاب کنید-</option>
                            <?php
                            foreach ($query_majors as $major) {
                                ?>
                                <option value="<?php echo $major['id'] ?>"> <?php echo $major['Majorname'] ?> </option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="">رشته ای وجود ندارد!</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Image">تصویر : </label>
                    <input type="file" class="form-control" name="Image" id="Image">
                    <small class="form-text text-muted">تصویر هنرآموز را وارد کنید.</small>
                </div>

                <button type="submit" name="add_teacher" class="btn btn-outline-primary">افزودن</button>
            </form>

        </main>

    </div>

</div>

</body>