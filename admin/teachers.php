<?php

include "../configs/session.php";
include "../configs/conf.php";


if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = $_GET['id'];

    $query_getteacherImage = $db->prepare("SELECT Image FROM teachers WHERE id = :id");
    $query_getteacherImage->execute(['id' => $id]);

    $query = $db->prepare('DELETE FROM teachers WHERE id = :id');
    $query->execute(['id' => $id]);

    unlink("../image/teachers/" . $query_getteacherImage->fetch()['Image']);

    header("Location:teachers.php?success=هنرآموز با موفقیت حذف شد!");
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
                <h3>هنرآموزان</h3>
                <a href="new_teacher.php" class="btn btn-outline-primary">افزودن هنرآموز</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>عکس</th>
                            <th>نام هنرآموز</th>
                            <th>رشته مربوطه</th>
                            <th>تحصیلات</th>
                            <th>مدیریت</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_teachers = $db->prepare("SELECT teachers.id, teachers.Nameandlastname, teachers.Degree, majors.Majorname, teachers.Image FROM teachers
JOIN majors ON teachers.Major_id = majors.id ORDER BY teachers.Nameandlastname ASC");
                        $query_teachers->execute();
                        if ($query_teachers->rowCount() > 0) {
                            foreach ($query_teachers->fetchAll() as $teacher) {
                                ?>
                                <tr>
                                    <td> <img src="../image/teachers/<?= $teacher['Image'] ?>" alt="" height="70px"
                                            width="70px"> </td>
                                    <td>
                                        <?= $teacher['Nameandlastname'] ?>
                                    </td>
                                    <td>
                                        <?= $teacher['Majorname'] ?>
                                    </td>
                                    <td>
                                        <?= $teacher['Degree'] ?>
                                    </td>
                                    <td>
                                        <a href="edit_teacher.php?id=<?php echo $teacher['id'] ?>"
                                            class="btn btn-outline-info">ویرایش</a>
                                        <a href="teachers.php?action=delete&id=<?php echo $teacher['id'] ?>"
                                            class="btn btn-outline-danger">حذف</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                هنرآموزی وجود ندارد!
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