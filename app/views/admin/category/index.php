<!--begin::App Main-->
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Quản lý danh mục</h3>
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
                    <h3 class="card-title">Tổng số danh mục: 100</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px">Id</th>
                                <th>Tên danh mục</th>
                                <th>Icon</th>
                                <th style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cate): ?>
                                <tr class="align-middle">
                                    <td><?= $cate['id'] ?></td>
                                    <td><?= $cate['name'] ?></td>
                                    <td><?= $cate['icon'] ?></td>
                                    <td>
                                        <div
                                            class="d-flex align-items-center justify-content-center">
                                            <button data-id="<?= $cate['id'] ?>" class="btn btn-outline-warning mx-1 btn-edit"><i
                                                    class="bi bi-pencil-square"></i></button>
                                            <button data-id="<?= $cate['id'] ?>" class="btn btn-outline-danger mx-1 btn-delete"><i
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm danh mục</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <label>Tên danh mục</label>
                        <input type="text" class="form-control" name="name">
                        <label class="mt-2">Icon</label>
                        <input type="text" class="form-control" name="icon">

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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa danh mục</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="category_id" name="id">
                        <label for>Tên danh mục</label>
                        <input type="text" class="form-control " id="category_name" name="name">
                        <label class="mt-2">Icon</label>
                        <input type="text" class="form-control " id="category_icon" name="icon">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- End modal edit -->
</main>
<!--end::App Main-->


<script>
    $(document).ready(function() {

        $("#addForm").submit(function(event) {
            event.preventDefault() //Ngăn chặn load lại trang

            let form_data = new FormData(this) // Lấy dữ liệu form

            $.ajax({
                url: "<?= _WEB_ROOT ?>/admin/category/addCategory",
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
                url: "<?= _WEB_ROOT ?>/admin/category/editCategory",
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
            let category_id = $(this).data("id")

            if (confirm("Bạn có chắc chắn muốn xóa danh mục này?")) {
                $.ajax({
                    url: "<?= _WEB_ROOT ?>/admin/category/deleteCategory",
                    type: "POST",
                    data: {
                        id: category_id
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
                    error: function() {
                        alert("Đã có lỗi xảy ra!");
                    }
                });
            }
        })

        $(".btn-edit").click(function() {
            let category_id = $(this).data("id");
            $.ajax({
                url: "<?= _WEB_ROOT ?>/admin/category/showInfo",
                type: "POST",
                data: {
                    id: category_id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.result) {
                        $('#category_id').val(response.id); // Gán ID danh mục vào input ẩn
                        $('#category_name').val(response.name); // Điền tên vào trường input
                        $('#category_icon').val(response.icon);

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