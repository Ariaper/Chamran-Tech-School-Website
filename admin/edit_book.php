<?php
include "../configs/session.php";
include "../configs/conf.php";

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    $query_majors = $db->prepare("SELECT * FROM majors");
    $query_majors->execute();

    $book = $db->prepare('SELECT books.id, books.Bookname, books.Book_grade, books.Booklink, majors.Majorname, majors.id AS major_id FROM books
JOIN majors ON majors.id = books.Major_id
WHERE books.id = :id');
    $book->execute(['id' => $book_id]);
    $book = $book->fetch();
}

if (isset($_POST['edit_book'])) {

    if (trim($_POST['Book_major']) != "" && trim($_POST['Book_grade']) != "" && trim($_POST['Bookname']) != "" && trim($_POST['Booklink']) != "") {

        $Book_major = $_POST['Book_major'];
        $Book_grade = $_POST['Book_grade'];
        $Bookname   = $_POST['Bookname'];
        $Booklink   = $_POST['Booklink'];

        $book_update = $db->prepare("UPDATE books SET Major_id =:Major_id, Book_grade = :Book_grade, Bookname=:Bookname, Booklink=:Booklink WHERE id=:id");
        $book_update->execute(['Major_id' => $Book_major, 'Book_grade' => $Book_grade, 'Bookname' => $Bookname, 'Booklink' => $Booklink, 'id' => $book_id]);


        header("Location:books.php?success=کتاب با موفقیت ویرایش شد!");
        exit();
    } else {
        header("Location:edit_book.php?id=$book_id&failed= تمام فیلد ها الزامی هست");
        exit();
    }
}

include("./includes/header.php");
?>


<!-- html -->

<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            <div class="d-flex justify-content-between mt-5">
                <h3>ویرایش کتاب</h3>
            </div>

            <hr>
            <?php
            if (isset($_GET['failed'])) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['failed'] ?>
                </div>
                <?php
            }
            ?>
            <form method="post" class="mb-5">
                <div class="form-group">
                    <label for="Bookcode">رشته مربوطه :</label>
                    <select class="form-control" name="Book_major" id="Book_major">
                        <option value="<?= $book['major_id'] ?>"> <?= $book['Majorname'] ?> </option>
                        <?php
                        $query_majors = $db->prepare("SELECT * FROM majors");
                        $query_majors->execute();
                        ?>
                        <?php
                        foreach ($query_majors->fetchAll() as $major):
                            ?>
                            <option value="<?php echo $major['id'] ?>"> <?php echo $major['Majorname'] ?> </option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Bookcode">پایه :</label>
                    <select class="form-control" name="Book_grade" id="Book_grade">
                        <option value="<?php if ($book['Book_grade'] == 1) {
                            echo 1;
                        } elseif ($book['Book_grade'] == 2) {
                            echo 2;
                        } elseif ($book['Book_grade'] == 3) {
                            echo 3;
                        } ?>">
                            <?php if ($book['Book_grade'] == 1) {
                                echo "اول";
                            } elseif ($book['Book_grade'] == 2) {
                                echo "دوم";
                            } elseif ($book['Book_grade'] == 3) {
                                echo "سوم";
                            } ?></option>
                        <option value="1">اول</option>
                        <option value="2">دوم</option>
                        <option value="3">سوم</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Bookname">نام کتاب :</label>
                    <input type="text" class="form-control" value="<?php echo $book['Bookname'] ?>" name="Bookname"
                        id="Bookname" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="Booklink">لینک :</label>
                    <input type="text" class="form-control" value="<?php echo $book['Booklink'] ?>" name="Booklink"
                        id="Booklink" maxlength="255">
                </div>

                <button type="submit" name="edit_book" class="btn btn-outline-primary">ویرایش</button>
            </form>

        </main>

    </div>

</div>

</body>