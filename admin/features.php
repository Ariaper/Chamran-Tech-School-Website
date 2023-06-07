<?php

include "../configs/session.php";
include "../configs/conf.php";


if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = $_GET['id'];

    $query_getfeatureImage = $db->prepare("SELECT Image FROM features WHERE id = :id");
    $query_getfeatureImage->execute(['id' => $id]);

    $query = $db->prepare('DELETE FROM features WHERE id = :id');
    $query->execute(['id' => $id]);

    unlink("../image/features/" . $query_getfeatureImage->fetch()['Image']);

    header("Location:features.php?success=با موفقیت حذف شد!");
    exit();
}

include("./includes/header.php");

?>

<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            <div class="d-flex justify-content-between mt-5">
                <?php
                if (isset($_GET["success"])) {
                    ?>

                    <div class="alert alert-success" role="alert">
                        <?= $_GET['success']; ?>
                    </div>
                <?php } ?>
                <h3>امکانات</h3>
                <a href="new_feature.php" class="btn btn-outline-primary">افزودن</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>عکس</th>
                            <th>عنوان</th>
                            <th>توضیحات</th>
                            <th>مدیریت</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_features = $db->prepare("SELECT * FROM features");
                        $query_features->execute();
                        if ($query_features->rowCount() > 0) {
                            foreach ($query_features->fetchAll() as $feature) {
                                ?>
                                <tr>
                                    <td> <img src="../image/features/<?= $feature['Image'] ?>" alt="" height="70px"
                                            width="70px"> </td>
                                    <td>
                                        <?= $feature['Title'] ?>
                                    </td>
                                    <td>
                                        <?= $feature['Description'] ?>
                                    </td>
                                    <td>
                                        <a href="edit_feature.php?id=<?php echo $feature['id'] ?>"
                                            class="btn btn-outline-info">ویرایش</a>
                                        <a href="features.php?action=delete&id=<?php echo $feature['id'] ?>"
                                            class="btn btn-outline-danger">حذف</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                چیزی وجود ندارد!
                            </div>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>

        </main>

    </div>

</div>