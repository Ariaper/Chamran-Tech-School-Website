<?php
include("configs/conf.php");

?>
<?php include('./includes/header.php'); ?>
<section class="my-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="my-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a class="text-decoration-none" href="./index.php">خانه</a></li>
                <li class="breadcrumb-item active">تابلو اعلانات</li>
            </ol>
        </nav>
        <div class="row">
            <?php
            $query_ann = $db->prepare("SELECT * FROM announcements ORDER BY date DESC");
            $query_ann->execute();

            $announcements = $query_ann->fetchAll();
            foreach ($announcements as $announce):
                ?>
                <div class="col-sm-4 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">
                                    <?php echo $announce["Title"] ?>
                                </h5>
                                <div><span class="badge badge-secondary"></span></div>
                            </div>
                            <p class="card-text text-justify">
                                <?php echo substr($announce['description'], 0, 100) . "..." ?>
                            </p>
                            <div class="d-flex justify-content-between">
                                <a href="announcements.php?id=<?php echo $announce["id"] ?> "
                                    class="btn btn-outline-primary stretched-link">مشاهده
                                    کامل</a>
                                <p> تاریخ :
                                    <?php echo $announce["date"] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        </div>
        <script>
            newPageTitle = " اعلانات | هنرستان شهید چمران";
            document.querySelector("title").textContent = newPageTitle;
        </script>
        <?php
        include("./includes/footer.php");
        ?>