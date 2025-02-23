<!--begin::App Main-->
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Quản lý nhân
                        viên</h3>
                </div>
                <div class="col-sm-6"><button
                        class="btn btn-outline-success float-sm-end" data-bs-toggle="modal" data-bs-target="#addModal"><i
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
                    <h3 class="card-title">Tổng số tài khoản: 100</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px">Id</th>
                                <th>Tên người dùng</th>
                                <th>Email</th>
                                <th>Trạng thái</th>
                                <th style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr class="align-middle">
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <?php if ($user['status'] == 1): ?>
                                        <td>Hoạt động</td>
                                    <?php else: ?>
                                        <td>Tạm ngừng</td>
                                    <?php endif; ?>
                                    <td>
                                        <div
                                            class="d-flex align-items-center justify-content-center">
                                            <button data-id="<?= $user['id'] ?>" class="btn btn-outline-warning mx-1 btn-show" data-bs-toggle="modal" data-bs-target="#editModal"><i
                                                    class="bi bi-pencil-square"></i></button>
                                            <button data-id="<?= $user['id'] ?>" data-status="<?= $user['status'] ?>" class="btn btn-outline-info mx-1 btn-status"><i
                                                    class="bi bi-arrow-repeat"></i></button>
                                            <button data-id="<?= $user['id'] ?>" class="btn btn-outline-danger mx-1 btn-delete"><i
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
                    <h5 class="modal-title">Thêm tài khoản</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <label>Tên người dùng</label>
                        <input type="text" class="form-control" name="name">
                        <label class="mt-2">Email</label>
                        <input type="email" class="form-control" name="email">
                        <label class="mt-2">Mật khẩu</label>
                        <input type="password" class="form-control" name="password">
                        <label class="mt-2">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" name="confirm">

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
                    <h5 class="modal-title">Sửa tài khoản</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" name="id" id="user_id">
                        <label>Tên người dùng</label>
                        <input type="text" class="form-control" name="name" id="user_name">
                        <label class="mt-2">Email</label>
                        <input type="email" class="form-control" name="email" id="user_email">
                        <label class="mt-2">Mật khẩu</label>
                        <input type="text" class="form-control" name="password" id="user_password">

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

        $(".btn-delete").click(function() {
            let user_id = $(this).data("id")

            if (confirm("Bạn có chắc chắn muốn xóa không?")) {
                $.ajax({
                    url: "<?= _WEB_ROOT ?>/admin/user/deleteUser",
                    type: "POST",
                    data: {
                        id: user_id
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

        $(".btn-status").click(function() {
            let user_id = $(this).data("id")
            let user_status = $(this).data("status")

            if (confirm("Bạn có chắc chắn muốn đổi trạng thái không?")) {
                $.ajax({
                    url: "<?= _WEB_ROOT ?>/admin/user/changeStatus",
                    type: "POST",
                    data: {
                        id: user_id,
                        status: user_status
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

        $(".btn-show").click(function() {
            let user_id = $(this).data("id");
            $.ajax({
                url: "<?= _WEB_ROOT ?>/admin/user/showInfo",
                type: "POST",
                data: {
                    id: user_id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.result) {
                        $('#user_id').val(response.id); // Gán ID danh mục vào input ẩn
                        $('#user_name').val(response.name); // Điền tên vào trường input
                        $('#user_email').val(response.email);
                        $('#user_password').val(response.password);

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
                error: function(jqXHR, textStatus, errorThrown) {
                    let errorMessage = `Lỗi Ajax: ${textStatus} \nMã lỗi: ${jqXHR.status} \nThông báo lỗi: ${errorThrown} \nPhản hồi từ server: ${jqXHR.responseText}`;
                    console.error(errorMessage);
                    alert(errorMessage); // Hiển thị lỗi chi tiết
                }
            })
        })

        $("#addForm").submit(function(event) {
            event.preventDefault() //Ngăn chặn load lại trang

            let form_data = new FormData(this) // Lấy dữ liệu form

            $.ajax({
                url: "<?= _WEB_ROOT ?>/admin/user/addUser",
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
                url: "<?= _WEB_ROOT ?>/admin/user/editUser",
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
    })
</script>