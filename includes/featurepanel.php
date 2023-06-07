<div class="col-md-4 my-5 my-md-0 ">
    <p class="text-center">بخش امکانات سایت</p>
    <ul class="list-group">
        <?php
        $query_majors = "SELECT * FROM majors";
        $majors       = $db->query($query_majors);
        foreach ($majors as $major) {
            ?>
            <li class="list-group-item"><a href="majors.php?major=<?= $major['Ref'] ?>">رشته <?= $major['Majorname'] ?> </a>
            </li>
            <?php
        }
        ?>
    </ul>
</div>