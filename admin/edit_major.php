<?php

include "../configs/session.php";
include "../configs/conf.php";

if (isset($_GET['id'])) {
    $major_id = $_GET['id'];

    $major = $db->prepare('SELECT * FROM majors WHERE id = :id');
    $major->execute(['id' => $major_id]);
    $major = $major->fetch();
}

if (isset($_POST['edit_major'])) {

    if (trim($_POST['Majorname']) != "" && trim($_POST['Ref']) != "" && trim($_POST['Body']) != "") {

        $Majorname = $_POST['Majorname'];
        $Ref       = $_POST['Ref'];
        $Body      = $_POST['Body'];

        $query_checkMajor = $db->prepare("SELECT * FROM majors WHERE Ref = :ref");
        $query_checkMajor->execute(['ref' => $Ref]);

        if ($query_checkMajor->rowCount > 0) {
            header("location:edit_major.php?id=$major_id&failed=یک رشته با همین نام وجود دارد!");
            exit();
        }

        $post_update = $db->prepare("UPDATE majors SET Majorname =:Majorname, Ref=:Ref, Body=:Body WHERE id=:id");
        $post_update->execute(['Majorname' => $Majorname, 'Ref' => $Ref, 'Body' => $Body, 'id' => $major_id]);

        header("Location:majors.php?success= رشته با موفقیت ویرایش شد");
        exit();
    } else {
        header("Location:edit_major.php?id=$major_id&failed= تمام فیلد ها الزامی هست");
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
                <h3>ویرایش رشته</h3>
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
                    <label for="Majorname">نام رشته:</label>
                    <input type="text" class="form-control" name="Majorname" id="Majorname"
                        value="<?php echo $major['Majorname'] ?>">
                    <small class="form-text text-muted">نام رشته</small>
                </div>
                <div class="form-group">
                    <label for="Ref">مرجع (نام انگلیسی رشته) :</label>
                    <input type="text" class="form-control" name="Ref" id="Ref" value="<?php echo $major['Ref'] ?>">
                    <small class="form-text text-muted">نام انگلیسی رشته</small>
                </div>
                <div class="form-group">
                    <label for="category">توضیحات رشته : </label>
                    <textarea class="form-control" name="Body" id="Body">
                        <?php echo $major['Body'] ?>
                    </textarea>
                </div>

                <button type="submit" name="edit_major" class="btn btn-outline-primary">ویرایش</button>
            </form>

        </main>

    </div>

</div>

</body>
<script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/translations/ar.js"></script>
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

</html>