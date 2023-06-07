<?php

include "../configs/session.php";
include "../configs/conf.php";

if (isset($_POST['add_book'])) {
    if (trim($_POST['Book_major']) != "" && trim($_POST['Book_grade']) != "" && trim($_POST['Bookname']) != "" && trim($_POST['Booklink']) != "") {

        $Bookname   = $_POST['Bookname'];
        $Book_major = $_POST['Book_major'];
        $Book_grade = $_POST['Book_grade'];
        $Booklink   = $_POST['Booklink'];

        $book_insert = $db->prepare("INSERT INTO books (Bookname, Major_id, Book_grade, Booklink) VALUES (:Bookname , :Major_id, :Book_grade, :Booklink)");
        $book_insert->execute(['Bookname' => $Bookname, 'Major_id' => $Book_major, 'Book_grade' => $Book_grade, 'Booklink' => $Booklink]);

        header("location:books.php?success=کتاب با موفقیت افزوده شد!");
        exit();

    } else {
        header("Location:new_book.php?failed= تمام فیلد ها الزامی هست");
        exit();
    }
}
include("./includes/header.php");
?>

<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            <div class="d-flex justify-content-between mt-5">
                <h3>افزودن کتاب</h3>
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
            <form method="post" class="mb-5" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="Book_major">رشته مربوطه:</label>
                    <select class="form-control" name="Book_major" id="Book_major">
                        <?php
                        $query_majors = $db->prepare("SELECT * FROM majors");
                        $query_majors->execute();

                        if ($query_majors->rowCount() > 0):
                            ?>
                            <option value="">-انتخاب کنید-</option>
                            <?php
                            foreach ($query_majors->fetchAll() as $major):
                                ?>
                                <option value="<?php echo $major['id'] ?>"> <?php echo $major['Majorname'] ?> </option>
                                <?php
                            endforeach;
                        else:
                            ?>
                            <option value="">رشته ای وجود ندارد!</option>
                            <?php
                        endif;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Book_grade">پایه :</label>
                    <select class="form-control" name="Book_grade" id="Book_grade">
                        <option value="">-انتخاب کنید-</option>
                        <option value="1">اول</option>
                        <option value="2">دوم</option>
                        <option value="3">سوم</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Bookname">نام کتاب :</label>
                    <input type="text" class="form-control" name="Bookname" id="Bookname" maxlength="50">
                    <small class="form-text text-muted">نام کتاب را وارد کنید.</small>
                </div>
                <div class="form-group">
                    <label for="Booklink">لینک دانلود کتاب :</label>
                    <input type="text" class="form-control" name="Booklink" id="Booklink" maxlength="255">
                    <small class="form-text text-muted"> لینک را وارد کنید.</small>
                </div>

                <button type="submit" name="add_book" class="btn btn-outline-primary">افزودن</button>
            </form>

        </main>

    </div>

</div>

</body>