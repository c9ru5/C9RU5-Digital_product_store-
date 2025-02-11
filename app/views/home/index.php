<div class="home-content">
      <div class="container mt-3">
        <div class="row mb-3">
          <!-- Submenu -->
          <div class="col-xl-3 d-flex">
            <div class="submenu flex-grow-1 p-3 rounded-3">
              <ul class="nav flex-column">
                <?php foreach ($category_list as $cate) : ?>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="<?=$cate['icon'] ?>"></i> &nbsp;&nbsp;<?= $cate['name'] ?>
                  </a>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>

          <!-- Slider -->
          <div class="col-xl-9 d-flex">
            <div id="carouselExampleIndicators"
              class="carousel slide mx-auto flex-grow-1">
              <div class="carousel-indicators ">
                <button type="button"
                  data-bs-target="#carouselExampleIndicators"
                  data-bs-slide-to="0"
                  class="active" aria-current="true"
                  aria-label="Slide 1"></button>
                <button type="button"
                  data-bs-target="#carouselExampleIndicators"
                  data-bs-slide-to="1"
                  aria-label="Slide 2"></button>
                <button type="button"
                  data-bs-target="#carouselExampleIndicators"
                  data-bs-slide-to="2"
                  aria-label="Slide 3"></button>
                <button type="button"
                  data-bs-target="#carouselExampleIndicators"
                  data-bs-slide-to="3"
                  aria-label="Slide 4"></button>
                <button type="button"
                  data-bs-target="#carouselExampleIndicators"
                  data-bs-slide-to="4"
                  aria-label="Slide 5"></button>
              </div>
              <div class="carousel-inner rounded-2">
                <div class="carousel-item active">
                  <img src="<?= _WEB_ROOT ?>/public/assets/images/slider1.png" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="<?= _WEB_ROOT ?>/public/assets/images/slider2.png" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="<?= _WEB_ROOT ?>/public/assets/images/slider3.png" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="<?= _WEB_ROOT ?>/public/assets/images/slider4.png" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="<?= _WEB_ROOT ?>/public/assets/images/slider5.png" alt="...">
                </div>
              </div>
              <button class="carousel-control-prev" type="button"
                data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon"
                  aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button"
                data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon"
                  aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xl-3">
            <img class="img-fluid rounded-3" src="<?= _WEB_ROOT ?>/public/assets/images/ads1.png" alt>
          </div>
          <div class="col-xl-3">
            <img class="img-fluid rounded-3" src="<?= _WEB_ROOT ?>/public/assets/images/ads2.png" alt>
          </div>
          <div class="col-xl-3">
            <img class="img-fluid rounded-3" src="<?= _WEB_ROOT ?>/public/assets/images/ads3.png" alt>
          </div>
          <div class="col-xl-3">
            <img class="img-fluid rounded-3" src="<?= _WEB_ROOT ?>/public/assets/images/ads4.png" alt>
          </div>
        </div>
      </div>

      <div class="container mt-5">
        <div style="display: flex; justify-content: space-between;">
          <div>
            <h5>Sản phẩm nổi bật</h5>
            <p>Danh sách những sản phẩm theo xu hướng mà có thể bạn sẽ thích</p>
          </div>
          <div>
            <button type="button" class="btn btn-success">Xem thêm</button>
          </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4">
          <?php foreach ($product_list as $product) : ?>
          <div class="col mt-3 ">
            <a class="text-decoration-none text-dark d-flex"
              href="<?= _WEB_ROOT ?>/chi-tiet-san-pham/ma-san-pham-<?= $product['id'] ?>">
              <!-- Bọc toàn bộ card trong thẻ a để tạo liên kết -->
              <div class="card border-0 bg-transparent mt-0 mx-auto"
                style="width: 18rem;">
                <img src="<?= _WEB_ROOT ?>/public/assets/images/<?= $product['image'] ?>" class="card-img-top rounded-3"
                  alt="...">
                <div class="card-body px-0">
                  <p class="card-title" style="font-weight: bolder;"><?= $product['name'] ?></p>
                  <span class="card-text"
                    style="font-weight: bolder;"><?= number_format($product['price'] - (($product['price'] * $product['discount_percent'])/100)) ?>đ</span>
                  <del style="margin-left: 10px;"><?= number_format($product['price'])  ?>đ</del>
                  <span
                    style="background: red; color: white; border-radius: 5px; padding: 5px; margin-left: 10px;">-<?= $product['discount_percent'] ?>%</span>
                </div>
              </div>
            </a>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="string mt-3"
          style="height: 1px; background: black; width: 100%;"></div>
      </div>

      <div class="container mt-5">
        <h5>Từ khóa nổi bật</h5>

        <div
          class="row row row-cols-2 row-cols-md-3 row-cols-lg-4  row-cols-xl-5 row-cols-xxl-6 d-flex mt-4">
          <div class="col d-flex">
            <h5 class="mx-auto text-bg-primary bdge mb-4">Làm việc</h5>
          </div>
          <div class="col d-flex">
            <h5 class="mx-auto text-bg-secondary bdge mb-4">Giải trí</h5>
          </div>
          <div class="col d-flex">
            <h5 class="mx-auto text-bg-success bdge mb-4">Học tập</h5>
          </div>
          <div class="col d-flex">
            <h5 class="mx-auto text-bg-danger bdge mb-4">Spotify</h5>
          </div>
          <div class="col d-flex">
            <h5 class="mx-auto bdge mb-4"
              style="background-color: orangered; color: white;">Wallet</h5>
          </div>
          <div class="col d-flex">
            <h5 class="mx-auto bdge mb-4"
              style="background-color: darkgoldenrod; color: white;">Youtube</h5>
          </div>
        </div>
      </div>

      <div class="fluid-container mt-5 d-flex align-items-center"
        style="background-image: url(<?= _WEB_ROOT ?>/public/assets/images/bg1.png); background-size: cover;">
        <div class="container my-5">
          <div style="display: flex; justify-content: space-between;">
            <div style="color: white;">
              <h5
                style="border-radius: 99px; border: solid white 1px; padding: 10px 15px 10px 15px ;"><i
                  style=" color: red; -webkit-text-stroke: 1px red;"
                  class="bi bi-graph-up-arrow"></i> #Sản
                phẩm bán chạy</h5>
              <!-- <p>Danh sách những sản phẩm theo xu hướng mà có thể bạn sẽ thích</p> -->
            </div>
            <div>
              <button type="button" class="btn btn-success">Xem thêm</button>
            </div>
          </div>

          <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4">
            <?php foreach ($product_list as $product) : ?>
            <div class="col mt-3">
              <a class="text-decoration-none text-dark d-flex" href="<?= _WEB_ROOT ?>/chi-tiet-san-pham/ma-san-pham-<?= $product['id'] ?>">
                <div
                  class="card border-0 bg-transparent text-white mt-0 mx-auto"
                  style="width: 18rem;;">
                  <img src="<?= _WEB_ROOT ?>/public/assets/images/<?= $product['image'] ?>" class="card-img-top rounded-3"
                    alt="...">
                  <div class="card-body px-0">
                    <p class="card-title" style="font-weight: bolder;"><?= $product['name'] ?></p>
                    <span class="card-text"
                      style="font-weight: bolder;"><?= number_format($product['price'] - (($product['price'] * $product['discount_percent'])/100)) ?>đ</span>
                    <del style="margin-left: 10px;"><?= number_format($product['price']) ?>đ</del>
                    <span
                      style="background: red; color: white; border-radius: 5px; padding: 5px;  margin-left: 10px;">-<?= $product['discount_percent'] ?>%</span>
                  </div>
                </div>
              </a>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="string mt-3"
            style="height: 1px; background: white; width: 100%;"></div>
        </div>
      </div>

      <div class="container mt-5 mb-5">
        <div style="display: flex; justify-content: space-between;">
          <div>
            <h5>Game trên Steam</h5>
            <p>Những trò chơi được đánh giá tốt, nội dung hấp dẫn thu hút đang
              chờ bạn</p>
          </div>
          <div>
            <button type="button" class="btn btn-success">Xem thêm</button>
          </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4">
        <?php foreach ($product_list as $product) : ?>
          <div class="col mt-3 ">
            <a class="text-decoration-none text-dark d-flex"
              href="<?= _WEB_ROOT ?>/chi-tiet-san-pham/ma-san-pham-<?= $product['id'] ?>">
              <!-- Bọc toàn bộ card trong thẻ a để tạo liên kết -->
              <div class="card border-0 bg-transparent mt-0 mx-auto"
                style="width: 18rem;">
                <img src="<?= _WEB_ROOT ?>/public/assets/images/<?= $product['image'] ?>" class="card-img-top rounded-3"
                  alt="...">
                <div class="card-body px-0">
                  <p class="card-title" style="font-weight: bolder;"><?= $product['name'] ?></p>
                  <span class="card-text"
                    style="font-weight: bolder;"><?= number_format($product['price'] - (($product['price'] * $product['discount_percent'])/100)) ?>đ</span>
                  <del style="margin-left: 10px;"><?= number_format($product['price']) ?>đ</del>
                  <span
                    style="background: red; color: white; border-radius: 5px; padding: 5px; margin-left: 10px;">-<?= $product['discount_percent'] ?>%</span>
                </div>
              </div>
            </a>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="string mt-3"
          style="height: 1px; background: black; width: 100%;"></div>
      </div>
    </div>