<?php
$query_banner = "SELECT * from banner";
$banners      = $db->query($query_banner);
?>
<section class="mt-1">
  <div class="text-center justify-content-center">
    <div class="bg-blue">
      <div class="container">
        <div id="carouselnum" class="carousel carousel-dark slide" data-bs-ride="carousel">
          <div class="carousel-indicators">

            <button type="button" data-bs-target="#carouselnum" data-bs-slide-to="0" class="active"></button>

          </div>
          <div class="carousel-inner">
            <?php
            if ($banners->rowCount() > 0) {
              foreach ($banners as $banner) {
                ?>
                <div class="carousel-item active" data-bs-interval="3000">
                  <img src="./image/banner/<?php echo $banner['banner'] ?>" class="d-block rounded mx-auto img-fluid"
                    alt="..." />
                </div>
                <?php
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <?php
      $query_hero = $db->prepare("SELECT hero FROM hero");
      $query_hero->execute();
      ?>
      <p class="lh-lg mt-3">
        <?= $query_hero->fetch()['hero']; ?>
      </p>
    </div>
  </div>
</section>