<?php
include("configs/conf.php");
?>
<!-- Head and Header -->
<?php
include("includes/header.php");
?>
<!-- Carousel -->
<?php
include("./includes/carousel.php");
?>
<!-- Main intro -->
<section class="mt-5">
  <div class="container-fluid">
    <h3 id="intro" class="text-primary text-center fw-bold my-3">معرفی مدرسه</h3>
    <div class="container-fluid text-center">
      <div class="row full bordergradiant">
        <div class="col-sm-6 borderleftgradiant ">
          <i class="bi bi-book fs-1"></i>
          <p>رشته ها</p>
          <p>برای مشاهده جزئیات هر رشته، روی آن کلیک کنید</p>
          <div class="row">
            <?php
            $query_majors = $db->prepare("SELECT * FROM majors");
            $query_majors->execute();

            foreach ($query_majors->fetchAll() as $major):
              ?>
              <div class="col-md-4">
                <div class="card m-2">
                  <a href="majors.php?major=<?php echo $major["Ref"] ?>">
                    <img src="image/majors/<?php echo $major["Image"] ?>" class="card-img-top" alt="..." />
                    <div class="card-body border-top border-3">
                      <h5 class="card-title">
                        <?php echo $major["Majorname"] ?>
                      </h5>
                    </div>
                  </a>
                </div>
              </div>
              <?php
            endforeach;
            ?>
          </div>
        </div>
        <div class="col-sm-6">
          <i class="bi bi-layers fs-1"></i>
          <p>امکانات</p>
          <div class="row">
            <?php
            $query_features = $db->prepare("SELECT * FROM features");
            $query_features->execute();

            foreach ($query_features->fetchAll() as $feature):
              ?>
              <div class="col-md-4">
                <div class="card m-2">
                  <img src="image/features/<?= $feature['Image'] ?>" class="card-img-top" alt="..." />
                  <div class="card-body">
                    <h5 class="card-title">
                      <?= $feature['Title'] ?>
                    </h5>
                    <p class="card-text">
                      <?= $feature['Description'] ?>
                    </p>
                  </div>
                </div>
              </div>
              <?php
            endforeach;
            ?>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-sm-6 borderleftgradiant ">
          <div class="col-sm-6 ">
            <i class="bi bi-people fs-1"></i>
            <p>کادر اداری مدرسه</p>
            <div class="row">
              <div class="col-6">
                <?php
                $query_cadre = $db->prepare("SELECT * FROM cadre");
                $query_cadre->execute();

                $result_cadre = $query_cadre->fetch();

                echo $result_cadre['cadre'];
                ?>

              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <i class="bi bi-journal-text fs-1"></i>
          <p>قوانین</p>
          <div class="row">
            <div class="col-6">
              <?php
              $query_rules = $db->prepare("SELECT * FROM rules");
              $query_rules->execute();

              $result_rules = $query_rules->fetch();

              echo $result_rules['rules'];
              ?>

            </div>
          </div>
        </div>
      </div>
      <div class="row border-top mt-5 align-items-center">
        <div class="col-sm-3">
          <i class="bi bi-geo-alt-fill fs-1"></i>
          <p>دسترسی</p>
        </div>
        <div class="col-sm-9">
          <div class="row">
            <?php
            $query_address = $db->prepare("SELECT * FROM address");
            $query_address->execute();

            $result_address = $query_address->fetch();
            ?>
            <div class="col text-start mt-3">
              <h3 id="contactus" class="fw-bold">آدرس:</h3>
              <p class="fw-bold">
                <?= $result_address['address']; ?>
              </p>
              <h4 class="fw-bold">پیدا کردن از روی نقشه:</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <iframe src="<?= $result_address['g_map'] ?>" width="250" height="200" style="border:0;"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row border-top mt-5 align-items-center">
      <h3 id="news" class="text-primary text-center fw-bold my-3">تابلو اعلانات</h3>
      <a href="all_announce.php" class="text-center">
        <p>مشاهده همه اعلامیه ها</p>
      </a>
      <div class="row">
        <?php

        $query_news = $db->prepare("SELECT * FROM announcements LIMIT 6");
        $query_news->execute();

        if ($query_news->rowCount() > 0):
          foreach ($query_news->fetchAll() as $new):
            ?>
            <div class="col-sm-4 mt-2">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <h5 class="card-title">
                      <?php echo $new["Title"] ?>
                    </h5>
                    <div><span class="badge badge-secondary"></span></div>
                  </div>
                  <p class="card-text text-justify">
                    <?php echo substr($new['description'], 0, 500) . "..." ?>
                  </p>
                  <div class="d-flex justify-content-between">
                    <a href="announcements.php?id=<?php echo $new["id"] ?> "
                      class="btn btn-outline-primary stretched-link">مشاهده
                      کامل</a>
                    <p> تاریخ :
                      <?php echo $new["date"] ?>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <?php
          endforeach;
        else:
          ?>
          <h4 class="text-primary text-center">هنوز اعلامیه ای وجود ندارد</h4>
          <?php
        endif;
        ?>
      </div>
</section>
<!-- Footer -->
<?php
include("includes/footer.php");
?>