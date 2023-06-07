<?php
include "../configs/session.php";
include "../configs/conf.php";



if (isset($_POST['save'])) {

    $query_cadre = $db->prepare("SELECT id FROM cadre");
    $query_cadre->execute();

    $id = $query_cadre->fetch()['id'];

    $cadre = $_POST['cadre'];


    $submit_cadre = $db->prepare("UPDATE cadre SET cadre = :cadre WHERE id = :id");
    $submit_cadre->execute(['cadre' => $cadre, 'id' => $id]);

    header("location:cadre.php?success=با موفقیت ثبت شد!");
    exit();
}

include "includes/header.php";
?>
<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            <div class="d-flex justify-content-between mt-5">
                <?php
                if (isset($_GET["success"])):
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_GET['success'] ?>
                    </div>
                <?php endif; ?>
                <h3>کادر اداری مدرسه</h3>
            </div>

            <div class="col border rounded bg-gray-300 m-5 p-2">
                <?php
                $query_cadre = $db->prepare("SELECT cadre FROM cadre");
                $query_cadre->execute();
                $result = $query_cadre->fetch();
                if ($result['cadre'] == '') {
                    echo "خالی!";
                } else {
                    echo $result['cadre'];
                } ?>
            </div>
            <form action="" method="POST">
                <label for="cadre">توضیحات کادر اداری و همچنان اسامی آنان را در اینجا میتوان ثبت نمود</label>
                <textarea class="form-control" name="cadre" id="cadre">

                </textarea>
                <button class="btn btn-primary m-1" name="save" type="submmit">ثبت</button>
            </form>


        </main>

    </div>

</div>
<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('cadre', {
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