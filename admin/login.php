<?php
session_start();
include("./includes/config.php");
include("./includes/db.php");

if (isset($_POST['login'])) {

    if (trim($_POST['username']) != "" || trim($_POST['password']) != "") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query_getUser = $db->prepare("SELECT * FROM admin WHERE username = :username");
        $query_getUser->execute(['username' => $username]);

        if ($query_getUser->rowCount() > 0) {
            $hashedPw = $query_getUser->fetch()['password'];
            if (password_verify($password, $hashedPw)) {
                $_SESSION['state_login'] = true;
                header("Location:./index.php");
                exit();
            } else {
                header("Location:login.php?failed=رمز عبور نادرست است!");
                exit();
            }
        } else {
            header("Location:login.php?failed=نام کاربری نادرست است!");
            exit();
        }
    } else {
        header("Location:login.php?failed=تمامی فیلد ها الزامی است!");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="../assets/css/bootstrap.rtl.min.css" />
    <link rel="stylesheet" href="./css/login.css" />

    <title>ورود مدیر</title>
</head>

<body>

    <div class="login">

        <h1 class="text-center">ورود مدیریت</h1>
        <?php
        if (isset($_GET["failed"])):
            ?>
            <div class="alert alert-danger" role="alert">
                <?= $_GET['failed'] ?>
            </div>
        <?php endif; ?>
        <?php
        if (isset($_GET["success"])):
            ?>
            <div class="alert alert-success" role="alert">
                <?= $_GET['success'] ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div>
                <label class="form-label" for="username">نام کاربری</label>
                <input class="form-control" name="username" id="username" required>

            </div>
            <div>
                <label class="form-label" for="password">رمز عبور</label>
                <input class="form-control" type="password" name="password" id="password" required>

            </div>

            <button class="btn btn-success w-100" type="submit" name="login">ورود</button>
        </form>

    </div>

</body>