<?php

include "../configs/session.php";
include "../configs/conf.php";

if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];

    $query_teachers = $db->prepare("SELECT teachers.id, teachers.Nameandlastname, teachers.Degree, majors.Majorname, majors.id AS majorid, teachers.Image FROM teachers
JOIN majors ON teachers.Major_id = majors.id
WHERE teachers.id = :id");
    $query_teachers->execute(['id' => $teacher_id]);

    $teacher = $query_teachers->fetch();
}

if (isset($_POST['edit'])) {

    if (trim($_POST['Nameandlastname']) != "" && trim($_POST['teacherMajor']) != "" && trim($_POST['Degree']) != "") {

        $Nameandlastname = $_POST['Nameandlastname'];
        $teacherMajor    = $_POST['teacherMajor'];
        $Degree          = $_POST['Degree'];

        if (trim($_FILES['Image']['name']) != "") {

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
                header("location:edit_teacher.php?failed=فرمت تصویر نادرست است!");
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

            $teacher_update = $db->prepare("UPDATE teachers SET Nameandlastname = :Nameandlastname, Major_id=:teacherMajor, Degree=:Degree, Image=:Image WHERE id=:id");
            $teacher_update->execute(['Nameandlastname' => $Nameandlastname, 'teacherMajor' => $teacherMajor, 'Degree' => $Degree, 'Image' => $uniqueImgName, 'id' => $teacher_id]);
        } else {
            $teacher_update = $db->prepare("UPDATE teachers SET Nameandlastname = :Nameandlastname, Major_id=:teacherMajor, Degree=:Degree WHERE id=:id");
            $teacher_update->execute(['Nameandlastname' => $Nameandlastname, 'teacherMajor' => $teacherMajor, 'Degree' => $Degree, 'id' => $teacher_id]);
        }
        header("Location:teachers.php?success= اطلاعات هنرآموز با موفقیت ویرایش شد");
        exit();
    } else {
        header("Location:edit_major.php?id=$teacher_id&failed= تمام فیلد ها الزامی هست");
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
                <h3>ویرایش اطلاعات هنرآموز</h3>
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
                    <label for="Nameandlastname">نام و نام خانوادگی هنرآموز:</label>
                    <input type="text" class="form-control" name="Nameandlastname" id="Nameandlastname"
                        value="<?php echo $teacher['Nameandlastname'] ?>">
                </div>
                <div class="form-group">
                    <label for="teacherMajor">رشته مربوطه</label>
                    <select class="form-control" name="teacherMajor" id="">
                        <option value="<?= $teacher['majorid'] ?>"><?= $teacher['Majorname'] ?></option>
                        <?php
                        $query_majors = $db->prepare("SELECT * FROM majors");
                        $query_majors->execute();
                        ?>
                        <?php
                        foreach ($query_majors as $major) {
                            ?>
                            <option value="<?php echo $major['id'] ?>"> <?php echo $major['Majorname'] ?> </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="Degree">مدرک تحصیلی</label>
                    <input type="text" class="form-control" value="<?= $teacher['Degree'] ?>" name="Degree" id="Degree">
                </div>
                <img class="img-fluid" src="../image/teachers/<?php echo $teacher['Image'] ?>" alt="" height="100px"
                    width="100px">
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
<script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
<script>
    CKEDITOR.replace('Body');
</script>

</html>