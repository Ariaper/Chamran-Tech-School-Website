<?php
include "../configs/session.php";
include "../configs/conf.php";



if (isset($_POST['change'])) {

    $oldpass   = $_POST['oldpass'];
    $newpass   = $_POST['newpass'];
    $newrepass = $_POST['newrepass'];

    $query_getpass = $db->prepare("SELECT * FROM admin WHERE id = 1");
    $query_getpass->execute();

    $hashedPw = $query_getpass->fetch()['password'];


    if ($newpass == $newrepass) {
        if (password_verify($oldpass, $hashedPw)) {
            $hash             = password_hash($newpass, PASSWORD_BCRYPT);
            $query_changePass = $db->prepare("UPDATE admin SET password = :password");
            $query_changePass->execute(['password' => $hash]);
            session_unset();
            session_destroy();
            header("location:login.php?success=رمز عبور تغییر کرد لطفا با رمز جدید وارد شوید!");
            exit();
        } else {
            header("location:changepassword.php?failed=رمز عبور فعلی نادرست است!");
            exit();
        }
    } else {
        header("location:changepassword.php?failed=رمز عبور با تکرار آن یکسان نیستند!");
        exit();
    }

}

include "includes/header.php";
?>
<div class="container-fluid">
    <div class="row">

        <?php include('./includes/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            <div class="d-flex justify-content-between mt-5">
                <?php
                if (isset($_GET["failed"])):
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_GET['failed'] ?>
                    </div>
                <?php endif; ?>
                <h3>تغییر رمز عبور</h3>
            </div>

            <form action="" method="POST">
                <label for="oldpass">رمز عبور فعلی</label>
                <input class="form-control" type="password" name="oldpass" id="" minlength="8" required>
                <label for="newpass">رمز جدید</label>
                <input class="form-control" type="password" name="newpass" id="" pattern="(?=.*\d)(?=.*[a-z]).{8,}"
                    minlength="8" title="باید از حروف انگلیسی و 8 نویسه باشد" required>
                <label for="newrepass">تکرار رمز جدید</label>
                <input class="form-control" type="password" name="newrepass" id="" pattern="(?=.*\d)(?=.*[a-z]).{8,}"
                    minlength="8" title="باید از حروف انگلیسی و 8 نویسه باشد" required>
                <input class="btn btn-primary form-control" type="submit" value="ثبت" name="change">
            </form>


        </main>

    </div>

</div>
</body>

</html>