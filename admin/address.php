<?php
include "../configs/session.php";
include "../configs/conf.php";

if (isset($_POST['save_address'])) {

    $query_address = $db->prepare("SELECT id FROM address");
    $query_address->execute();

    $id = $query_address->fetch()['id'];

    $address = $_POST['address'];


    $submit_address = $db->prepare("UPDATE address SET address = :address WHERE id = :id");
    $submit_address->execute(['address' => $address, 'id' => $id]);

    header("location:address.php?success=با موفقیت ثبت شد!");
    exit();
}

if (isset($_POST['save_gmap'])) {

    $query_address = $db->prepare("SELECT id FROM address");
    $query_address->execute();

    $id = $query_address->fetch()['id'];

    $g_map = $_POST['g_map'];


    $submit_address = $db->prepare("UPDATE address SET g_map = :g_map WHERE id = :id");
    $submit_address->execute(['g_map' => $g_map, 'id' => $id]);

    header("location:address.php?success=با موفقیت ثبت شد!");
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
                <h3>آدرس</h3>
            </div>
            <div class="row">
                <div class="col border rounded bg-gray-300 m-5 p-2">
                    <h5 class="text-center">آدرس:</h5>
                    <?php
                    $query_address = $db->prepare("SELECT address FROM address");
                    $query_address->execute();
                    $result = $query_address->fetch();
                    if ($result['address'] == '') {
                        echo "خالی!";
                    } else {
                        echo $result['address'];
                    } ?>
                </div>
                <div class="col border rounded m-5 p-1">
                    <h5 class="text-center">آدرس گوگل مپ:</h5>
                    <?php
                    $query_address = $db->prepare("SELECT g_map FROM address");
                    $query_address->execute();
                    $result = $query_address->fetch();
                    if ($result['g_map'] == '') {
                        echo "خالی!";
                    } else {
                        ?>
                        <iframe src="<?= $result['g_map']; ?>" width="250" height="200" style="border:0;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                    } ?>
                </div>
            </div>
            <form action="" method="POST">
                <label for="address">آدرس جدید:</label>
                <textarea class="form-control" name="address" id="address">

                </textarea>
                <button class="btn btn-primary m-1" name="save_address" type="submmit">ثبت</button>
            </form>
            <hr>

            <form action="" method="post">
                <label for="g_map">آدرس گوگل مپ</label>
                <input class="form-control" type="text" value="" name="g_map">
                <button class="btn btn-primary" type="submit" name="save_gmap">ثبت</button>
            </form>

        </main>

    </div>

</div>
<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('address', {
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