<?php

include "../configs/session.php";
include "../configs/conf.php";

$query_articles = $db->prepare("SELECT * FROM articles ORDER BY id ASC");
$query_articles->execute();

$articles = $query_articles->fetchAll();

if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = $_GET['id'];

    $query_articleimg = $db->prepare("SELECT Image FROM articles WHERE id = :id");
    $query_articleimg->execute(['id' => $id]);
    $imgName = $query_articleimg->fetch();

    $query_deletearticle = $db->prepare("DELETE FROM articles WHERE id = :id");
    $query_deletearticle->execute(['id' => $id]);

    unlink("../image/articles/" . $imgName['Image']);

    header("location:articles.php?success=اخبار با موفقیت حذف شد!");
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
                <h3>اخبار </h3>
                <a href="new_article.php" class="btn btn-outline-primary">افزودن اخبار</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>عکس</th>
                            <th>عنوان</th>
                            <th>نویسنده</th>
                            <th>متن</th>
                            <th>تاریخ</th>
                            <th>مدیریت</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($query_articles->rowCount() > 0) {
                            foreach ($articles as $article) {
                                ?>
                                <tr>
                                    <td><img src="../image/articles/<?php echo $article['Image'] ?>" width="175px"
                                            height="150px">
                                    </td>

                                    <td>
                                        <?php echo $article['Title'] ?>
                                    </td>
                                    <td>
                                        <?php echo $article['Author'] ?>
                                    </td>
                                    <td>
                                        <?php echo $article['Description'] ?>
                                    </td>
                                    <td>
                                        <?php echo $article['date'] ?>
                                    </td>
                                    <td>
                                        <a href="edit_article.php?id=<?php echo $article['id'] ?>"
                                            class="btn btn-outline-info">ویرایش</a>
                                        <a href="articles.php?action=delete&id=<?php echo $article['id'] ?>"
                                            class="btn btn-outline-danger">حذف</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                هنوز خبری وجود ندارد
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