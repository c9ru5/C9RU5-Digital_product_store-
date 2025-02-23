<!--begin::App Main-->
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Quản lý đơn hàng</h3>
                </div>
                <!-- <div class="col-sm-6"><button class="btn btn-outline-success  float-sm-end"><i class="bi bi-plus-circle"></i></button></div> -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Tổng đã thành công: 100</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px">Id</th>
                                <th>Tên người dùng</th>
                                <th>Thời gian tạo</th>
                                <th>Tổng tiền (đ)</th>
                                <th style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr class="align-middle">
                                    <td><?= $order['id'] ?></td>
                                    <?php foreach ($users as $user): ?>
                                        <?php if ($user['id'] == $order['user_id']): ?>
                                            <td><?= $user['name'] ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <td><?= $order['date_created'] ?></td>
                                    <td><?= number_format($order['value']) ?></td>
                                    <td>
                                        <div
                                            class="d-flex align-items-center justify-content-center">
                                            <button class="btn btn-outline-warning mx-1 btn-show"
                                                data-id="<?= $order['id'] ?>"><i
                                                    class="bi bi-box-arrow-up-right"></i></button>
                                            <!-- <button class="btn btn-outline-info mx-1"><i
                              class="bi bi-arrow-repeat"></i></button>
                          <button class="btn btn-outline-danger mx-1"><i
                              class="bi bi-x-circle"></i></button> -->
                                            <!-- <button class="btn btn-outline-danger mx-1"><i
                              class="bi bi-trash"></i></button> -->
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <div class="d-flex mt-2">
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
        <!--end::Container-->
    </div>
    <!--end::App Content-->
    <!-- Modal info -->
    <div class="modal fade" id="infoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin đơn hàng</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h4>Thông tin khách hàng:</h4>
                    <div class="mt-2"
                        style="display: flex; justify-content: space-between;"><span>Tên
                            người dùng:</span> <span id="order_name"></span></div>
                    <div class="mt-2"
                        style="display: flex; justify-content: space-between;"><span>Email:</span>
                        <span id="order_email"></span>
                    </div>
                    <div class="mt-2"
                        style="display: flex; justify-content: space-between;"><span>Thời
                            gian tạo đơn:</span>
                        <span id="order_date"></span>
                    </div>
                    <hr class="mt-2">
                    <h4>Danh sách sản phẩm:</h4>
                    <table class="table table-bordered w-100 mt-2" id="product_list">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th style="width: 100px;">Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">
                                    <div
                                        style="display: flex; justify-content: space-between;">
                                        <span>Tổng tiền:</span>
                                        <span id="order_value"></span>
                                    </div>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- End modal info -->
</main>
<!--end::App Main-->

<script>
    $(document).ready(function() {

        $(".btn-show").click(function() {
            let order_id = $(this).data("id");
            $.ajax({
                url: "<?= _WEB_ROOT ?>/admin/order/showInfo",
                type: "POST",
                data: {
                    id: order_id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.result) {
                        $('#order_name').text(response.name); // Điền tên vào trường input
                        $('#order_email').text(response.email);
                        $('#order_date').text(response.date);
                        $('#order_value').text(new Intl.NumberFormat().format(response.value) + "đ");


                        // Xóa dữ liệu cũ trước khi thêm mới
                        $("#product_list tbody").empty();
                        // Duyệt qua mảng sản phẩm và thêm vào bảng
                        $.each(response.products, function(index, product) {
                            let row = `<tr>
                                            <td>${product.name}</td>
                                            <td>${product.quantity}</td>
                                        </tr>`;
                            $("#product_list tbody").append(row);
                        });

                        // Mở modal
                        $('#infoModal').modal('show')
                    } else {
                        notification({
                            title: response.title,
                            mess: response.mess,
                            type: response.type
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let errorMessage = `Lỗi Ajax: ${textStatus} \nMã lỗi: ${jqXHR.status} \nThông báo lỗi: ${errorThrown} \nPhản hồi từ server: ${jqXHR.responseText}`;
                    console.error(errorMessage);
                    alert(errorMessage); // Hiển thị lỗi chi tiết
                }
            })
        })
    })
</script>