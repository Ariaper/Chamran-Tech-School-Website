<?php
include "../configs/session.php";
include "../configs/conf.php";


$query_gallery = $db->prepare("SELECT * FROM gallery ORDER BY date DESC");
$query_gallery->execute();

if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = $_GET['id'];

    $query_getImage = $db->prepare("SELECT * FROM gallery WHERE id = :id");
    $query_getImage->execute(['id' => $id]);


    $query = $db->prepare('DELETE FROM gallery WHERE id = :id');

    $query->execute(['id' => $id]);


    unlink("../image/gallery/" . $query_getImage->fetch()['Image']);

    header("Location:gallery.php?success=با موفقیت حذف شد!");
    exit();
}

include("./includes/header.php");
?>

<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <?php
            if (isset($_GET['success'])):
                ?>
                <div class="alert alert-success" role="alert">
                    <?= $_GET['success'] ?>
                </div>
            <?php endif; ?>
            <div class="d-flex justify-content-between mt-5">
                <h3>گالری</h3>
                <a href="new_image.php" class="btn btn-outline-primary">افزودن عکس</a>
            </div>

            <div class="row py-5 align-items-center align-content-center">
                <?php
                foreach ($query_gallery->fetchAll() as $Image):
                    ?>
                    <div class="col-md-4 border">
                        <p class="text-center">
                            تاریخ
                            <?= $Image['date'] ?>
                        </p>
                        <img src="../image/gallery/<?php echo $Image['Image'] ?>" alt="" style="max-width:500px">
                        <a href="./gallery.php?action=delete&id=<?php echo $Image['id'] ?>"
                            class="btn btn-danger m-1">حذف</a>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>

        </main>

    </div>

</div>