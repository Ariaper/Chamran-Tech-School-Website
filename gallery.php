<?php include("configs/conf.php"); ?>
<!-- Head and Header -->
<?php
include("includes/header.php");
$query_galleryimage = "SELECT * FROM gallery ORDER BY date DESC";
$images             = $db->query($query_galleryimage);
?>
<section class="my-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="my-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a class="text-decoration-none" href="../index.php">خانه</a></li>
                <li class="breadcrumb-item active">گالری</li>

            </ol>
        </nav>
        <div class="row">
            <h5 class="text-primary">گالری</h5>
            <div class="col">
                <div class="row">
                    <?php
                    if ($images->rowCount() > 0) {
                        foreach ($images as $image) {
                            ?>

                            <div class="col-md-4 m-2">
                                <p class="text-center">
                                    <?= $image['date'] ?>تاریخ
                                </p>
                                <img src="image/gallery/<?php echo $image['Image'] ?>" alt="" class="img-fluid"><?php echo "<br/>" ?>
                            </div>

                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Footer -->
<?php
include("includes/footer.php");
?>