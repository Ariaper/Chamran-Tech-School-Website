<?php

include "../configs/session.php";
include "../configs/conf.php";
include "./includes/date.php";

if (isset($_POST['add'])) {
    if (trim($_POST['Title']) != "" && trim($_POST['description']) != "") {
        $initdate = new DateTime();

        $Title       = $_POST['Title'];
        $description = $_POST['description'];
        $date        = $formatter->format($initdate);

        $announce_insert = $db->prepare("INSERT INTO announcements (Title, description, date) VALUES (:Title , :description, :date)");
        $announce_insert->execute(['Title' => $Title, 'description' => $description, 'date' => $date]);

        header("location:announcements.php?success=اطلاعیه با موفقیت افزوده شد!");
        exit();

    } else {
        header("Location:new_announcement.php?failed= تمام فیلد ها الزامی هست");
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
                <h3>افزودن کتاب</h3>
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
                    <input type="text" class="form-control" name="Title" id="Title" maxlength="50">

                </div>
                <div class="form-group">
                    <label for="description">توضیحات اطلاعیه:</label>
                    <textarea name="description" id="description"></textarea>

                </div>

                <button type="submit" name="add" class="btn btn-outline-primary">افزودن</button>
            </form>

        </main>

    </div>

</div>

<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description', {
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