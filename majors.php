<?php
include("configs/conf.php");

if (isset($_GET['major'])) {
    $majorname    = $_GET['major'];
    $query_majors = $db->prepare("SELECT * FROM majors WHERE Ref = :majorname");
    $query_majors->execute(['majorname' => $majorname]);

    if ($query_majors->rowCount() == 1) {
        $result = $query_majors->fetch();
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
                <li class="breadcrumb-item active">رشته ها</li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= $result['Majorname'] ?>
                </li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-8">
                <h5 class="text-primary">
                    <?= $result['Majorname'] ?>
                </h5>
                <p>
                <p>
                    <?= $result['Body'] ?>
                </p>
                </p>
                <img src="./image/majors/<?= $result['Image_detail'] ?>" alt="" class="img-fluid">
                <h6 class="text-primary mt-5 fs-5">
                    لیست هنرآموزان این رشته :

                </h6>
                <table class="table table-hover table-bordered border-success">
                    <thead>
                        <tr>
                            <th scope="col">تصویر</th>
                            <th scope="col">نام و نام خانوادگی</th>
                            <th scope="col">تحصیلات</th>
                        </tr>
                    </thead>
                    <?php
                    $query_teacher = $db->prepare("SELECT * FROM teachers WHERE Major_id = :id");
                    $query_teacher->execute(['id' => $result['id']]);
                    $result_teacher = $query_teacher->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <tbody>
                        <?php foreach ($result_teacher as $teacher): ?>
                            <tr>
                                <td><img src="./image/teachers/<?php echo $teacher['Image'] ?>" width="100px"
                                        height="100px" /></td>
                                <td>
                                    <?php echo $teacher['Nameandlastname'] ?>
                                </td>
                                <td>
                                    <?php echo $teacher['Degree'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h6 class="text-primary mt-5 fs-5 ">
                    دروس تخصصی رشته
                    <?= $result['Majorname'] ?>
                </h6>
                <div class="accordion mt-3" id="accordionBooks">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                سال اول
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionBooks">
                            <div class="accordion-body">
                                <?php
                                $query_lessons = $db->prepare("SELECT * FROM books WHERE Major_id =:major_id AND Book_grade=:grade");
                                $query_lessons->execute(["major_id" => $result['id'], "grade" => 1]);
                                $query_lessons = $query_lessons->fetchAll();
                                ?>
                                <p>برای دانلود هر کتاب روی اسم مورد نظر کلیک کنید</p>
                                <?php

                                foreach ($query_lessons as $query_lesson) {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="<?php echo $query_lesson["Booklink"] ?>" class="book_link">
                                                <?php echo $query_lesson["Bookname"] ?>
                                            </a>
                                        </li>
                                    </ul>
                                    <?php
                                }


                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                سال دوم
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionBooks">
                            <div class="accordion-body">
                                <?php

                                $query_lessons = $db->prepare("SELECT * FROM books WHERE Major_id =:major_id AND Book_grade=:grade");
                                $query_lessons->execute(["major_id" => $result['id'], "grade" => 2]);
                                $query_lessons = $query_lessons->fetchAll();
                                ?>
                                <p>برای دانلود هر کتاب روی اسم مورد نظر کلیک کنید</p>
                                <?php

                                foreach ($query_lessons as $query_lesson) {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="<?php echo $query_lesson["Booklink"] ?>" class="book_link">
                                                <?php echo $query_lesson["Bookname"] ?>
                                            </a>
                                        </li>
                                    </ul>
                                    <?php
                                }


                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                سال سوم
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionBooks">
                            <div class="accordion-body">
                                <?php
                                $query_lessons = $db->prepare("SELECT * FROM books WHERE Major_id =:major_id AND Book_grade=:grade");
                                $query_lessons->execute(["major_id" => $result['id'], "grade" => 3]);
                                $query_lessons = $query_lessons->fetchAll();
                                ?>
                                <p>برای دانلود هر کتاب روی اسم مورد نظر کلیک کنید</p>
                                <?php

                                foreach ($query_lessons as $query_lesson) {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="<?php echo $query_lesson["Booklink"] ?>" class="book_link">
                                                <?php echo $query_lesson["Bookname"] ?>
                                            </a>
                                        </li>
                                    </ul>
                                    <?php


                                }


                                ?>
                            </div>
                        </div>
                    </div>
                </div> <br>
                <p class="fw-bold"> شرایط ورود به رشته
                    <?= $result['Majorname'] ?>
                </p>
                <ul>
                    <li>معدل بالای 18 سال نهم</li>
                    <li>کسب نمره ریاضی بالای 12 در کارنامه نهم</li>
                    <li> علاقه به رشته ی
                        <?= $result['Majorname'] ?>
                    </li>
                </ul>
            </div>
            <?php
            include("./includes/featurepanel.php")
                ?>
        </div>
        <script>
            newPageTitle = " <?= $result['Majorname'] ?> | هنرستان شهید چمران";
            document.querySelector("title").textContent = newPageTitle;
        </script>
        <?php
        include("./includes/footer.php");
        ?>