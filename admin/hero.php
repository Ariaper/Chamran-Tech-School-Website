<?php
include "../configs/session.php";
include "../configs/conf.php";



if (isset($_POST['save'])) {

    $query_hero = $db->prepare("SELECT id FROM hero");
    $query_hero->execute();

    $id = $query_hero->fetch()['id'];

    $hero = $_POST['hero'];


    $submit_hero = $db->prepare("UPDATE hero SET hero = :hero WHERE id = :id");
    $submit_hero->execute(['hero' => $hero, 'id' => $id]);

    header("location:hero.php?success=با موفقیت ثبت شد!");
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
                <h3>متن</h3>
            </div>

            <div class="col border rounded bg-gray-300 m-5 p-2">
                <?php
                $query_hero = $db->prepare("SELECT hero FROM hero");
                $query_hero->execute();
                $result = $query_hero->fetch();
                if ($result['hero'] == '') {
                    echo "خالی!";
                } else {
                    echo $result['hero'];
                } ?>
            </div>
            <form action="" method="POST">
                <label for="hero">متن مدرسه را میتوان در اینجا ثبت نمود یا ویرایش نمود</label>
                <textarea class="form-control" name="hero" id="hero">

                </textarea>
                <button class="btn btn-primary m-1" name="save" type="submmit">ثبت</button>
            </form>


        </main>

    </div>

</div>
<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('hero', {
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