<?php

include "../configs/session.php";
include "../configs/conf.php";

$query_announce = $db->prepare("SELECT * FROM announcements ORDER BY date DESC");
$query_announce->execute();

$announcements = $query_announce->fetchAll();

if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = $_GET['id'];

    $query_deleteannounce = $db->prepare("DELETE FROM announcements WHERE id = :id");
    $query_deleteannounce->execute(['id' => $id]);

    header("location:announcements.php?success=اطلاعیه با موفقیت حذف شد!");
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
                <h3>تابلو اعلانات|اطلاعیه ها</h3>
                <a href="new_announcement.php" class="btn btn-outline-primary">افزودن اطلاعیه</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>عنوان</th>
                            <th>متن</th>
                            <th>تاریخ</th>
                            <th>مدیریت</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($query_announce->rowCount() > 0) {
                            foreach ($announcements as $announcement) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $announcement['Title'] ?>
                                    </td>
                                    <td>
                                        <?php echo $announcement['description'] ?>
                                    </td>
                                    <td>
                                        <?php echo $announcement['date'] ?>
                                    </td>
                                    <td>
                                        <a href="edit_announcement.php?id=<?php echo $announcement['id'] ?>"
                                            class="btn btn-outline-info">ویرایش</a>
                                        <a href="announcements.php?action=delete&id=<?php echo $announcement['id'] ?>"
                                            class="btn btn-outline-danger">حذف</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                هنوز اطلاعیه ای وجود ندارد
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