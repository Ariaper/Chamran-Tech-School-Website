<?php
include "../configs/session.php";
include "../configs/conf.php";

if (isset($_GET['id'])) {
    $a_id = $_GET['id'];

    $query_announce = $db->prepare("SELECT * FROM announcements WHERE id = :id");
    $query_announce->execute(['id' => $a_id]);
    $announce = $query_announce->fetch();
}

if (isset($_POST['edit'])) {

    if (trim($_POST['Title']) != "" && trim($_POST['description']) != "") {

        $Title       = $_POST['Title'];
        $description = $_POST['description'];

        $update_announce = $db->prepare("UPDATE announcements SET Title = :Title, description = :description WHERE id = :id");
        $update_announce->execute(['Title' => $Title, 'description' => $description, 'id' => $a_id]);

        header("location:announcements.php?success=اطلاعیه با موفقیت ویرایش شد!");
        exit();

    } else {
        header("Location:edit_announcement.php?id=$a_id&failed= تمام فیلد ها الزامی هست");
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
                <h3>ویرایش اطلاعیه</h3>
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
                    <input type="text" class="form-control" name="Title" id="Title" value="<?= $announce['Title'] ?>"
                        maxlength="50">

                </div>
                <div class="form-group">
                    <label for="description">توضیحات اطلاعیه:</label>
                    <textarea name="description" id="description"><?= $announce['description'] ?></textarea>

                </div>

                <button type="submit" name="edit" class="btn btn-outline-primary">ویرایش</button>
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