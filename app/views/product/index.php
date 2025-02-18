<div class="product-content">
  <div class="container mt-3">
    <div class="row mb-3">
      <!-- Submenu -->
      <div class="col-6 col-lg-3 d-flex">
        <div class="submenu flex-grow-1 p-3 rounded-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link <?= (!isset($current_category['id']) ? 'active' : '') ?>" href="<?= _WEB_ROOT ?>/cua-hang">
                &nbsp;&nbsp;Tất cả sản phẩm
              </a>
            </li>
            <?php foreach ($categories as $cate) : ?>
              <li class="nav-item">
                <a class="nav-link <?= (isset($current_category['id']) && $current_category['id'] == $cate['id']) ? 'active' : '' ?>" href="<?= _WEB_ROOT ?>/cua-hang/<?= $cate['id'] ?>">
                  <i class="<?= $cate['icon'] ?>"></i> &nbsp;&nbsp;<?= $cate['name'] ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="col-6 col-lg-9">
        <div class="container mt-5">
          <div style="display: flex; justify-content: space-between;">
            <div>
              <h5><?= !isset($current_category['name']) ? 'Tất cả sản phẩm' : $current_category['name'] ?></h5>
              <a href="<?= _WEB_ROOT ?>/cua-hang" style="text-decoration: none;"
                class="text-success"><i class="bi bi-arrow-repeat"
                  style="color: #198754; -webkit-text-stroke: .5px #198754;"></i>
                Khôi phục bộ lọc</a>
            </div>

            <div>
              <button type="button" class="btn btn-success"><i
                  style="-webkit-text-stroke: .5px white;"
                  class="bi bi-arrow-down-up"></i>
                Giá</button>
            </div>
          </div>
          <div class="string mt-3"
            style="height: 1px; background: black; width: 100%;"></div>
          <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
            <?php foreach ($products as $pro): ?>
              <div class="col mt-3">
                <a class="text-decoration-none text-dark d-flex" href="<?= _WEB_ROOT ?>/chi-tiet-san-pham/ma-san-pham-<?= $pro['id'] ?>">
                  <div class="card border-0 bg-transparent mt-0 mx-auto"
                    style="width: 18rem;">
                    <img src="<?= _WEB_ROOT ?>/public/assets/images/<?= $pro['image'] ?>" class="card-img-top rounded-3"
                      alt="...">
                    <div class="card-body px-0">
                      <p class="card-title" style="font-weight: bolder;"><?= $pro['name'] ?></p>
                      <span class="card-text" style="font-weight: bolder;"><?= number_format($pro['price'] - (($pro['price'] * $pro['discount_percent']) / 100)) ?>đ</span>
                      <del style="margin-left: 10px;"><?= number_format($pro['price'])  ?>đ</del>
                      <span
                        style="background: red; color: white; border-radius: 5px; padding: 5px;  margin-left: 10px;">-<?= $pro['discount_percent'] ?>%</span>
                    </div>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="d-flex mt-3">
            <?php if ($total_pages > 1): ?>
              <nav aria-label="Page navigation" class="mx-auto">
                <ul class="pagination pagination-sm">
                  <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                      <a class="page-link <?= ($i == $current_page) ? 'bg-success border-success text-white' : 'text-success border-success' ?>" href="?page=<?= $i; ?>">
                        <?= $i; ?>
                      </a>
                    </li>
                  <?php endfor; ?>
                </ul>
              </nav>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>