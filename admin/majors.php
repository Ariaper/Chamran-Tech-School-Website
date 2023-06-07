<?php

include "../configs/session.php";
include "../configs/conf.php";

$query_majors = $db->prepare("SELECT * FROM majors ORDER BY id ASC");
$query_majors->execute();

$majors = $query_majors->fetchAll();

if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = $_GET['id'];

    $query_majorimg = $db->prepare("SELECT Image, Image_detail FROM majors WHERE id = :id");
    $query_majorimg->execute(['id' => $id]);
    $imgName = $query_majorimg->fetch();

    $query_deleteMajor = $db->prepare("DELETE FROM majors WHERE id = :id");
    $query_deleteMajor->execute(['id' => $id]);

    unlink("../image/majors/" . $imgName['Image']);
    unlink("../image/majors/" . $imgName['Image_detail']);

    header("location:majors.php?success=رشته با موفقیت حذف شد!");
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
                if (isset($_GET["success"])):
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_GET['success'] ?>
                    </div>
                <?php endif; ?>
                <h3>رشته ها</h3>
                <a href="new_major.php" class="btn btn-outline-primary">افزودن رشته</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>عکس</th>
                            <th>نام رشته</th>
                            <th>مرجع</th>
                            <th>مدیریت</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($query_majors->rowCount() > 0) {
                            foreach ($majors as $major) {
                                ?>
                                <tr>
                                    <td><img src="../image/majors/<?php echo $major['Image'] ?>" width="75px" height="75px">
                                    </td>

                                    <td>
                                        <?php echo $major['Majorname'] ?>
                                    </td>
                                    <td>
                                        <?php echo $major['Ref'] ?>
                                    </td>
                                    <td>
                                        <a href="edit_major.php?id=<?php echo $major['id'] ?>"
                                            class="btn btn-outline-info">ویرایش</a>
                                        <a href="majors.php?action=delete&id=<?php echo $major['id'] ?>"
                                            class="btn btn-outline-danger">حذف</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                هنوز رشته ای وجود ندارد
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