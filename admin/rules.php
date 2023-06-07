<?php
include "../configs/session.php";
include "../configs/conf.php";



if (isset($_POST['save'])) {

    $query_rules = $db->prepare("SELECT id FROM rules");
    $query_rules->execute();

    $id = $query_rules->fetch()['id'];

    $rules = $_POST['rules'];


    $submit_rules = $db->prepare("UPDATE rules SET rules = :rules WHERE id = :id");
    $submit_rules->execute(['rules' => $rules, 'id' => $id]);

    header("location:rules.php?success=با موفقیت ثبت شد!");
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
                <h3>قوانین</h3>
            </div>

            <div class="col border rounded bg-gray-300 m-5 p-2">
                <?php
                $query_rules = $db->prepare("SELECT rules FROM rules");
                $query_rules->execute();
                $result = $query_rules->fetch();
                if ($result['rules'] == '') {
                    echo "خالی!";
                } else {
                    echo $result['rules'];
                } ?>
            </div>
            <form action="" method="POST">
                <label for="rules">قوانین مدرسه را میتوان در اینجا ثبت نمود یا ویرایش نمود</label>
                <textarea class="form-control" name="rules" id="rules">

                </textarea>
                <button class="btn btn-primary m-1" name="save" type="submmit">ثبت</button>
            </form>


        </main>

    </div>

</div>
<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('rules', {
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