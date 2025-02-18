<div class="detail-content">
    <div class="container">
        <div class="row mt-5">
            <div class="col-5">
                <img src="<?= _WEB_ROOT ?>/public/assets/images/<?= $product['image'] ?>" class="img-fluid rounded-3" alt="">
            </div>
            <div class="col-7">
                <p>Sản phẩm</p>
                <h3><?= $product['name'] ?></h3>
                <p><i class="bi bi-box2"></i> Tình trạng:
                    <?= $product['quantity'] > 0 ? '<span class="text-success">Còn hàng</span>' : '<span class="text-danger">Hết hàng</span>'; ?>
                    <!-- <span class="text-danger">Hết hàng</span> -->
                </p>
                <p><i class="bi bi-tag"></i> Thể loại: <?= $product['genre'] ?></p>
                <div class="d-flex align-items-center">
                    <h3 class="text-danger" style="font-weight: bolder;"><?= number_format($product['price'] - (($product['price'] * $product['discount_percent']) / 100)) ?>đ</h3>
                    <del style="margin-left: 10px;"><?= number_format($product['price']) ?>đ</del>
                    <span
                        style="background: red; color: white; border-radius: 5px; padding: 5px;  margin-left: 10px;">-<?= $product['discount_percent'] ?>%</span>
                </div>
                <?php if ($product['quantity']): ?>
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="d-flex mt-3">
                            <button type="button" class="btn btn-success mx-2" style="width: 30%;"><i
                                    class="bi bi-credit-card-fill"></i> Mua ngay</button>
                            <button type="button" class="btn text-success mx-2" id="btn-add-cart"
                                style="border: solid 1px #198754; width: 30%;"><i class="bi bi-cart-plus"></i> Thêm vào
                                giỏ</button>
                        </div>
                    <?php else: ?>
                        <div class="d-flex mt-3">
                            <button type="button" class="btn btn-success mx-2" style="width: 30%;" onclick="return checkLogin()"><i
                                    class="bi bi-credit-card-fill"></i> Mua ngay</button>
                            <button type="button" class="btn text-success mx-2" onclick="return checkLogin()"
                                style="border: solid 1px #198754; width: 30%;"><i class="bi bi-cart-plus"></i> Thêm vào
                                giỏ</button>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="d-flex mt-3">
                        <button type="button" class="btn btn-success mx-2" style="width: 30%;" disabled><i
                                class="bi bi-credit-card-fill"></i> Mua ngay</button>
                        <button @click="addToCart(pro)" type="button" class="btn text-success mx-2"
                            style="border: solid 1px #198754; width: 30%;" disabled><i class="bi bi-cart-plus"></i> Thêm vào
                            giỏ</button>
                    </div>
                <?php endif; ?>


                <!-- <div class="d-flex mt-3">
                        <button type="button" class="btn btn-success mx-2" style="width: 30%;" disabled><i
                                class="bi bi-credit-card-fill"></i> Mua ngay</button>
                        <button @click="addToCart(pro)" type="button" class="btn text-success mx-2"
                            style="border: solid 1px #198754; width: 30%;" disabled><i class="bi bi-cart-plus"></i> Thêm vào
                            giỏ</button>
                    </div> -->

            </div>
        </div>

        <div class="mt-5 border border-secondary p-5 rounded-3">
            <h3>Mô tả sản phẩm</h3>
            <span>
                <?= $product['product_description'] ?>
            </span>
        </div>


        <div class="comment-section mt-5">
            <!-- Form bình luận -->
            <form>
                <div class="mb-3">
                    <h5 for="comment" class="form-label">Bình luận</h5>
                    <textarea id="comment" class="form-control" rows="3" placeholder="Nhập nội dung..."></textarea>
                </div>
                <button type="submit" class="btn btn-success">Gửi bình luận</button>
            </form>

            <!-- Hiển thị danh sách bình luận -->
            <!-- <div class="comments-list mt-4">
                    <h5>Bình luận của mọi người</h5>
                    <div v-for="(comment, index) in comments" :key="index" class="comment-item p-2 mt-2 border rounded">
                        <p>{{ comment }}</p>
                    </div>
                </div> -->
        </div>


    </div>

    <div class="container mt-5 mb-5">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <h5>Sản phẩm liên quan</h5>
            </div>
            <div>
                <button type="button" class="btn btn-success">Xem thêm</button>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4">
            <?php foreach ($related_product as $product) : ?>
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
                                    style="font-weight: bolder;"><?= $product['price'] - (($product['price'] * $product['discount_percent']) / 100) ?>đ</span>
                                <del style="margin-left: 10px;"><?= $product['price'] ?>đ</del>
                                <span
                                    style="background: red; color: white; border-radius: 5px; padding: 5px; margin-left: 10px;">-<?= $product['discount_percent'] ?>%</span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="string mt-3" style="height: 1px; background: black; width: 100%;"></div>
    </div>
</div>

<script>
    function checkLogin() {
        notification({
            title: "Chú ý",
            mess: "Vui lòng đăng nhập",
            type: "warning",
        });
        return false; // Ngăn không cho chuyển trang
    }
    document.addEventListener("DOMContentLoaded", function() {
        const addCartBtn = document.getElementById("btn-add-cart");

        if (addCartBtn) {
            addCartBtn.addEventListener("click", function() {
                fetch("<?= _WEB_ROOT ?>/Cart/addCart", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            product_id: <?= $product['id'] ?>
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));
            });
        }
    });
</script>