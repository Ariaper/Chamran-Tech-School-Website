<?php

include "../configs/session.php";
include "../configs/conf.php";

$query_books = $db->prepare("SELECT books.id, books.Bookname, books.Book_grade, books.Booklink, majors.Majorname FROM books
JOIN majors ON books.Major_id = majors.id ORDER BY majors.Majorname ASC");
$query_books->execute();


if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = $db->prepare('DELETE FROM books WHERE id = :id');

    $query->execute(['id' => $id]);
    header("Location:books.php?success=کتاب با موفقیت حذف شد!");
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
                <h3>کتاب ها</h3>
                <a href="new_book.php" class="btn btn-outline-primary">افزودن کتاب</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>نام کتاب</th>
                            <th>رشته مربوطه</th>
                            <th>پایه</th>
                            <th>لینک</th>
                            <th>مدیریت</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($query_books->rowCount() > 0):
                            foreach ($query_books->fetchAll() as $book):
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $book['Bookname'] ?>
                                    </td>
                                    <td>
                                        <?php echo $book['Majorname'] ?>
                                    </td>
                                    <td>
                                        <?php echo $book['Book_grade'] ?>
                                    </td>
                                    <td><a href="<?php echo $book['Booklink'] ?>"> <?php echo $book['Booklink'] ?> </a></td>

                                    <td>
                                        <a href="edit_book.php?id=<?php echo $book['id'] ?>"
                                            class="btn btn-outline-info">ویرایش</a>

                                        <a href="books.php?action=delete&id=<?php echo $book['id'] ?>"
                                            class="btn btn-outline-danger">حذف</a>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                        else:
                            ?>
                            <div class="alert alert-danger" role="alert">
                                کتابی موجود نیست!
                            </div>
                            <?php
                        endif;
                        ?>

                    </tbody>
                </table>
            </div>

        </main>

    </div>

</div>
<?php unset($_SESSION["deletedbook"]); ?>