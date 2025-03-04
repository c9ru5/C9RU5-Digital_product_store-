<div class="cart-content">
    <div class="container my-5 rounded-3 border border-secondary">
        <?php if (!empty($cart)): ?>
            <div class="row">
                <div class="col-8 p-5 pe-0">
                    <h3>Giỏ hàng</h3>
                    <?php foreach ($cart as $detail): ?>
                        
                        <div class="card mt-3"
                            style="max-width: 100%; display: flex;">
                            <div class="row g-0">
                                <div class="col-md-4 mx-3 my-auto">
                                    <img src="<?= _WEB_ROOT . "/public/assets/images/" . $detail['image'] ?>" class="card-img rounded-3" alt="...">
                                </div>
                                <div class="col">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <p class="card-title" style="font-weight: bolder;"><?= $detail['name'] ?></p>
                                                <span class="card-text" style="font-weight: bolder;"><?= number_format(($detail['price'] - ($detail['price'] * $detail['discount_percent']) / 100) * $detail['cart_quantity']) ?>đ</span>
                                                <del style="margin-left: 10px;"><?= number_format($detail['price'] * $detail['cart_quantity']) ?>đ</del>
                                                <span
                                                    style="background: red; color: white; border-radius: 5px; padding: 5px; margin-left: 10px;">
                                                    <?= $detail['discount_percent'] ?>%
                                                </span>
                                            </div>
                                            <div class="col-3">
                                                <div class="d-flex">
                                                    <nav aria-label="Quantity navigation" class="mx-auto">
                                                        <ul class="pagination pagination-sm">
                                                            <li class="page-item">
                                                                <a class="page-link text-success border-success" href="<?= _WEB_ROOT ?>/cart/decreaseCart/<?= $detail['detail_id'] ?>">-</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <span class="page-link text-success border-success text-center">
                                                                    <?= $detail['cart_quantity'] ?>
                                                                </span>
                                                            </li>
                                                            <li class="page-item">
                                                                <a class="page-link text-success border-success" href="<?= _WEB_ROOT ?>/cart/increaseCart/<?= $detail['detail_id'] ?>">+</a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </div>

                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col">
                                                <p><i class="bi bi-box2"></i> Tình trạng:
                                                    <?php if ($detail['stock_quantity'] >= $detail['cart_quantity']): ?>
                                                        <span class="text-success">Còn hàng</span>
                                                    <?php else: ?>
                                                        <span class="text-danger">Hết hàng</span>
                                                    <?php endif; ?>

                                                </p>
                                            </div>
                                            <div class="col-2 d-flex justify-content-end">
                                                <h4 class="btn-delete" data-id="<?= $detail['detail_id'] ?>" style="cursor: pointer;"><i class="bi bi-trash"
                                                        style="color: red;"></i></h4>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php
                    $balance = $_SESSION['user']['balance'];
                    $total_price = 0;
                    foreach ($cart as $detail) {
                        $total_price += ($detail['price'] - ($detail['price'] * $detail['discount_percent']) / 100) * $detail['cart_quantity'];
                    }
                    $_SESSION['value'] = $total_price;
                    ?>
                </div>
                <div class="col-4 p-5">
                    <h3>Thanh toán</h3>
                    <div class="d-flex justify-content-between mt-2">
                        <span>Tổng giá trị sản phẩm:</span>
                        <strong><?= number_format($total_price) ?>đ</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mt-2">
                        <span>Tổng giá trị phải thanh toán:</span>
                        <strong><?= number_format($total_price) ?>đ</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>Số dư hiện tại:</span>
                        <strong><?= number_format($balance) ?>đ</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>Số tiền cần nạp thêm:</span>
                        <strong><?= number_format(($deposit = $total_price - $balance >= 0 ? $total_price - $balance : 0)) ?>đ</strong>
                    </div>
                    <?php if ($deposit == 0): ?>
                        <button type="button" class="btn btn-success mt-3" style="width: 100%;"><i
                                class="bi bi-credit-card-fill"></i> Mua ngay</button>
                    <?php else: ?>
                        <a href="<?= _WEB_ROOT ?>/thanh-toan" type="button" class="btn btn-success mt-3" style="width: 100%;"><i
                                class="bi bi-credit-card-fill"></i> Nạp thêm vào tài khoản</a>
                    <?php endif; ?>

                    <p class="text-center mt-3" style="color: gray;">Quét mã thanh toán không cần nạp tiền</p>
                    <button type="button" class="btn btn-primary" style="width: 100%; background-color: #005baa;"><i
                            class="bi bi-qr-code-scan"></i> Mua siêu tốc qua Mobile Banking</button>
                    <button type="button" class="btn mt-3 text-light" style="width: 100%; background-color: #ae2070;">
                        <svg xmlns="http://www.w3.org/2000/svg" height="21" viewBox="0 0 96 87"
                            preserveAspectRatio="xMidYMid meet">
                            <g>
                                <title>Momo</title>
                                <rect stroke="null" id="svg_1" fill="#AE2070" stroke-width="0" height="87" width="96"
                                    ry="10" rx="10" y="0" x="0" />
                                <path stroke="null" id="svg_2" fill="#fff"
                                    d="m69.79664,9.19443c-8.94916,0 -16.20344,6.92584 -16.20344,15.46988c0,8.54398 7.25428,15.46988 16.20344,15.46988c8.94916,0 16.20336,-6.9259 16.20336,-15.46988c0,-8.54404 -7.2542,-15.46988 -16.20336,-15.46988zm0,22.07206c-3.79668,0 -6.8814,-2.94508 -6.8814,-6.5698c0,-3.6248 3.08473,-6.56988 6.8814,-6.56988c3.7966,0 6.88133,2.94508 6.88133,6.56988c0,3.62473 -3.08473,6.5698 -6.88133,6.5698zm-20.8814,-10.45348l0,19.35348l-9.32203,0l0,-19.45054c0,-1.45643 -1.22035,-2.62153 -2.74574,-2.62153c-1.52546,0 -2.74582,1.1651 -2.74582,2.62153l0,19.45054l-9.32203,0l0,-19.45054c0,-1.45643 -1.22028,-2.62153 -2.74574,-2.62153c-1.52538,0 -2.74574,1.1651 -2.74574,2.62153l0,19.45054l-9.28815,0l0,-19.35348c0,-6.40802 5.45763,-11.61858 12.1695,-11.61858c2.74574,0 5.25421,0.87382 7.28816,2.33019c2.03387,-1.45637 4.57623,-2.33019 7.28808,-2.33019c6.71191,0 12.1695,5.21056 12.1695,11.61858zm20.8814,26.02042c-8.94916,0 -16.20344,6.9259 -16.20344,15.46988c0,8.54406 7.25428,15.46988 16.20344,15.46988c8.94916,0 16.20336,-6.92582 16.20336,-15.46988c0,-8.54398 -7.2542,-15.46988 -16.20336,-15.46988zm0,22.07206c-3.79668,0 -6.8814,-2.94508 -6.8814,-6.5698c0,-3.62473 3.08473,-6.56988 6.8814,-6.56988c3.7966,0 6.88133,2.94516 6.88133,6.56988c0,3.62473 -3.08473,6.5698 -6.88133,6.5698zm-20.8814,-10.45348l0,19.35356l-9.32203,0l0,-19.45062c0,-1.45635 -1.22035,-2.62145 -2.74574,-2.62145c-1.52546,0 -2.74582,1.1651 -2.74582,2.62145l0,19.45062l-9.32203,0l0,-19.45062c0,-1.45635 -1.22028,-2.62145 -2.74574,-2.62145c-1.52538,0 -2.74574,1.1651 -2.74574,2.62145l0,19.45062l-9.28815,0l0,-19.35356c0,-6.40799 5.45763,-11.61858 12.1695,-11.61858c2.74574,0 5.25421,0.87384 7.28816,2.33019c2.03387,-1.45635 4.54235,-2.33019 7.28808,-2.33019c6.71191,0 12.1695,5.21059 12.1695,11.61858z" />
                            </g>
                        </svg>
                        Mua siêu tốc với Momo</button>
                </div>
            </div>

        <?php else: ?>
            <div class="m-5 text-center">
                <h3>Giỏ hàng trống!</h3>
                <p>Thêm sản phẩm vào giỏ và quay lại trang này để thanh toán nha bạn <3</p>
                        <img loading="lazy" src="https://cdn.divineshop.vn/static/4e0db8ffb1e9cac7c7bc91d497753a2c.svg"
                            class="Ea" alt="Giỏ hàng trống">
            </div>
        <?php endif; ?>
        <!-- <div class="m-5 text-center">
                <h3>Giỏ hàng trống!</h3>
                <p>Thêm sản phẩm vào giỏ và quay lại trang này để thanh toán nha bạn <3</p>
                        <img loading="lazy" src="https://cdn.divineshop.vn/static/4e0db8ffb1e9cac7c7bc91d497753a2c.svg"
                            class="Ea" alt="Giỏ hàng trống">
            </div> -->
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteBtns = document.querySelectorAll(".btn-delete");

        deleteBtns.forEach(button => {
            button.addEventListener("click", function() {
                const detailId = this.getAttribute("data-id"); // Lấy ID sản phẩm từ data-id

                fetch("<?= _WEB_ROOT ?>/Cart/deleteCart", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            detail_id: detailId
                        })
                    })
                    .then(response => response.text()) // Đọc text thay vì JSON ngay
                    .then(text => {
                        try {
                            return JSON.parse(text); // Cố gắng parse JSON
                        } catch (error) {
                            throw new Error("Lỗi JSON: " + text); // Nếu lỗi, in nội dung thực tế
                        }
                    })
                    .then(data => {
                        
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));

            });
        });
    });
</script>