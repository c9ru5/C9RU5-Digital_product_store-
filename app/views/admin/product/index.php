<!--begin::App Main-->
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Quản lý sản phẩm</h3>
                </div>
                <div class="col-sm-6"><button
                        class="btn btn-outline-success float-sm-end"
                        data-bs-toggle="modal" data-bs-target="#addModal"><i
                            class="bi bi-plus-circle"></i></button></div>
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
                    <h3 class="card-title">Tổng loại sản phẩm: 100</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px">Id</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá (đ)</th>
                                <th>Phần trăm giảm (%)</th>
                                <th>Số lượng</th>
                                <th>Lượt bán</th>
                                <th>Danh mục</th>
                                <th style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr class="align-middle">
                                    <td><?= $product['id'] ?></td>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= number_format($product['price']) ?></td>
                                    <td><?= $product['discount_percent'] ?></td>
                                    <td><?= $product['quantity'] ?></td>
                                    <td><?= $product['sales'] ?></td>
                                    <?php foreach ($categories as $cate): ?>
                                        <?php if ($cate['id'] == $product['category_id']): ?>
                                            <td><?= $cate['name'] ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <td>
                                        <div
                                            class="d-flex align-items-center justify-content-center">
                                            <button class="btn btn-outline-warning mx-1 btn-edit" data-id="<?= $product['id'] ?>"><i
                                                    class="bi bi-pencil-square"></i></button>
                                            <button data-id="<?= $product['id'] ?>" data-image="<?= $product['image'] ?>" class="btn btn-outline-danger mx-1 btn-delete"><i
                                                    class="bi bi-trash"></i></button>
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
    <!-- Modal add -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm sản phẩm</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" enctype="multipart/form-data">

                        <div class="pickImage">
                            <div class="preview" onclick="this.nextElementSibling.click()">
                                <span>Nhấp để chọn ảnh</span>
                                <img class="imagePreview" src="" alt="Ảnh sản phẩm" style="display: none;">
                            </div>
                            <input type="file" class="fileInput" accept="image/*" style="display: none" onchange="loadFile(event)" name="image">
                        </div>


                        <div class="row cols-2 mt-2">
                            <div class="col">
                                <label for>Tên sản phẩm</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="col">
                                <label for>Giá (đ)</label>
                                <input type="number" name="price" class="form-control">
                            </div>
                        </div>

                        <div class="row cols-2 mt-2">
                            <div class="col">
                                <label>Danh mục</label>
                                <select name="category" id class="form-control">
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for>Thể loại</label>
                                <input name="genre" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="row cols-2 mt-2">
                            <div class="col">
                                <label for>Phần trăm giảm (%)</label>
                                <input name="discount" type="number" class="form-control">
                            </div>
                            <div class="col">
                                <label for>Số lượng</label>
                                <input name="quantity" type="number" class="form-control">
                            </div>
                        </div>

                        <label for class="mt-2">Mô tả</label>
                        <textarea style="height: 20vh;" name="describe" id class="form-control"></textarea>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- End modal add -->
    <!-- Modal edit -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa sản phẩm</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" enctype="multipart/form-data">
                        <input type="hidden" value="" id="product_id" name="id">
                        <div class="pickImage">
                            <div class="preview" onclick="this.nextElementSibling.click()">
                                <span>Nhấp để chọn ảnh</span>
                                <img class="imagePreview" src="" alt="Ảnh sản phẩm" style="display: none;" id="product_image">
                            </div>
                            <input name="image" type="file" class="fileInput" accept="image/*" style="display: none" onchange="loadFile(event)">
                        </div>

                        <div class="row cols-2 mt-2">
                            <div class="col">
                                <label for>Tên sản phẩm</label>
                                <input type="text" class="form-control" name="name" id="product_name">
                            </div>
                            <div class="col">
                                <label for>Giá (đ)</label>
                                <input type="number" name="price" id="product_price" class="form-control">
                            </div>
                        </div>


                        <div class="row cols-2 mt-2">
                            <div class="col">
                                <label>Danh mục</label>
                                <select name="category" id="product_category" class="form-control">
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for>Thể loại</label>
                                <input type="text" class="form-control" name="genre" id="product_genre">
                            </div>
                        </div>



                        <div class="row cols-2 mt-2">
                            <div class="col">
                                <label for>Phần trăm giảm (%)</label>
                                <input type="number" class="form-control" name="discount" id="product_discount">
                            </div>
                            <div class="col">
                                <label for>Số lượng</label>
                                <input type="number" class="form-control" name="quantity" id="product_quantity">
                            </div>
                        </div>

                        <label for class="mt-2">Mô tả</label>
                        <textarea style="height: 20vh;" name="describe" id="product_describe" class="form-control"></textarea>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- End modal add -->
</main>
<!--end::App Main-->

<script>
    function loadFile(event) {
        let input = event.target; // Lấy input file đang thay đổi
        let modal = input.closest(".modal"); // Xác định modal chứa input đó

        let image = modal.querySelector(".imagePreview"); // Lấy đúng ảnh xem trước trong modal
        let previewContainer = modal.querySelector(".preview"); // Lấy khung preview

        if (input.files && input.files[0]) {
            image.src = URL.createObjectURL(input.files[0]); // Tạo URL ảnh tạm
            image.style.display = "block"; // Hiển thị ảnh
            previewContainer.querySelector("span").style.display = "none"; // Ẩn chữ "Nhấp để chọn ảnh"
        }
    }
    $(document).ready(function() {

        $("#addForm").submit(function(event) {
            event.preventDefault() //Ngăn chặn load lại trang

            let form_data = new FormData(this) // Lấy dữ liệu form

            $.ajax({
                url: "<?= _WEB_ROOT ?>/admin/product/addProduct",
                type: "POST",
                data: form_data,
                processData: false, // Không xử lý dữ liệu (FormData)
                contentType: false, // Không đặt kiểu dữ liệu
                dataType: "json",
                success: function(response) {
                    if (response.result == true) {
                        location.reload(); // Tải lại trang
                    } else {
                        notification({
                            title: response.title,
                            mess: response.mess,
                            type: response.type
                        });
                    }

                },
                error: function() {
                    alert("Đã có lỗi xảy ra!")
                }

            })
        })

        $("#editForm").submit(function(event) {
            event.preventDefault() //Ngăn chặn load lại trang

            let form_data = new FormData(this) // Lấy dữ liệu form

            $.ajax({
                url: "<?= _WEB_ROOT ?>/admin/product/editProduct",
                type: "POST",
                data: form_data,
                processData: false, // Không xử lý dữ liệu (FormData)
                contentType: false, // Không đặt kiểu dữ liệu
                dataType: "json",
                success: function(response) {
                    if (response.result == true) {
                        location.reload(); // Tải lại trang
                    } else {
                        notification({
                            title: response.title,
                            mess: response.mess,
                            type: response.type
                        });
                    }

                },
                error: function() {
                    alert("Đã có lỗi xảy ra!")
                }

            })
        })

        $(".btn-delete").click(function() {
            let product_id = $(this).data("id")
            let product_image = $(this).data("image")

            if (confirm("Bạn có chắc chắn muốn xóa?")) {
                $.ajax({
                    url: "<?= _WEB_ROOT ?>/admin/product/deleteProduct",
                    type: "POST",
                    data: {
                        id: product_id,
                        image: product_image
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.result) {
                            location.reload() // Reload lại trang sau khi xóa
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
                });
            }
        })

        $(".btn-edit").click(function() {
            let product_id = $(this).data("id");
            $.ajax({
                url: "<?= _WEB_ROOT ?>/admin/product/showInfo",
                type: "POST",
                data: {
                    id: product_id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.result) {
                        $('#product_id').val(response.id); // Gán ID danh mục vào input ẩn
                        $('#product_name').val(response.name); // Điền tên vào trường input
                        $('#product_image').attr("src", "<?= _WEB_ROOT ?>/public/assets/images/" + response.image).css("display", "block");
                        $('#editModal .preview span').css("display", "none"); // Ẩn chữ "Nhấp để chọn ảnh"
                        $('#product_category').val(response.category);
                        $('#product_genre').val(response.genre);
                        $('#product_price').val(response.price);
                        $('#product_discount').val(response.discount);
                        $('#product_quantity').val(response.quantity);
                        $('#product_describe').val(response.describe);

                        // Mở modal
                        $('#editModal').modal('show')
                    } else {
                        notification({
                            title: response.title,
                            mess: response.mess,
                            type: response.type
                        });
                    }
                },
                error: function() {
                    alert("Đã có lỗi xảy ra!")
                }
            })
        })
    })
</script>