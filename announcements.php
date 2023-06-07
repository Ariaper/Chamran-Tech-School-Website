<?php
include("configs/conf.php");

if (isset($_GET['id'])) {
    $announce_id = $_GET['id'];
    $query_ann   = $db->prepare("SELECT * FROM announcements WHERE id = :id");
    $query_ann->execute(['id' => $announce_id]);
    if ($query_ann->rowCount() == 1) {
        $result = $query_ann->fetch();
    } else {
        header("location:index.php");
        exit();
    }
} else {
    header("location:index.php");
    exit();
}
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
            <div class="col-md-8">
                <h5 class="text-primary">
                    <?= $result['Title'] ?>
                </h5>
                <p>تاریخ
                    <?= $result['date'] ?>
                </p>
                <?= $result['description'] ?>

                <br><br><br>
                <p class="text-warning">پایان متن-</p>
            </div>
            <div class="col-md-4 my-5 my-md-0 ">
                <p class="text-center">اعلامیه های دیگر</p>
                <ul class="list-group">
                    <?php
                    $query_ann     = "SELECT * FROM announcements";
                    $announcements = $db->query($query_ann);
                    foreach ($announcements as $announcement) {
                        ?>
                        <li class="list-group-item"><a href="announcements.php?id=<?php echo $announcement["id"] ?>"><?php echo $announcement['Title'] ?> </a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <script>
            newPageTitle = " <?= $result['Title'] ?> | هنرستان شهید چمران";
            document.querySelector("title").textContent = newPageTitle;
        </script>
        <?php
        include("./includes/footer.php");
        ?>