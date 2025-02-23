<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-white" data-bs-theme="light">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#"
                    role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>

        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#"
                    role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>
            <!--end::Navbar Search-->


            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit"
                        style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link">
                    <?php if (!empty($_SESSION['user']['image'])): ?>
                        <img
                            src="<?= _WEB_ROOT ?>/public/assets/images/<?= $_SESSION['user']['image'] ?>"
                            class="user-image rounded-circle"
                            alt="User Image" />
                    <?php else: ?>
                        <img
                            src="<?= _WEB_ROOT ?>/public/assets/images/c9ru5-circle.png"
                            class="user-image rounded-circle"
                            alt="User Image" />
                    <?php endif; ?>
                    <span class="d-none d-md-inline"><?= $_SESSION['user']['name'] ?></span>
                </a>

            </li>
            <li>
                <a href="<?= _WEB_ROOT ?>/dang-xuat" class="btn btn-outline-danger">Đăng xuất</a>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--end::Header-->
<!--begin::Sidebar-->
<aside class="app-sidebar bg-light shadow" data-bs-theme="light">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="#" class="brand-link">
            <!--begin::Brand Image-->
            <img
                src="<?= _WEB_ROOT ?>/public/assets/images/c9ru5-circle.png"
                alt="c9ru5 logo"
                class="brand-image opacity-75 " />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">C9RU5 ADMIN</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="<?= _WEB_ROOT ?>/admin/thong-ke" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Thống kế</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= _WEB_ROOT ?>/admin/quan-ly-danh-muc" class="nav-link">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>Quản lý danh mục</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= _WEB_ROOT ?>/admin/quan-ly-san-pham" class="nav-link">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>Quản lý sản phẩm</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>
                            Quản lý tài khoản
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= _WEB_ROOT ?>/admin/quan-ly-khach-hang" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Tài khoản khách hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= _WEB_ROOT ?>/admin/quan-ly-nhan-vien" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Tài khoản nhân viên</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-cart-check"></i>
                        <p>
                            Quản lý đơn hàng
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= _WEB_ROOT ?>/admin/quan-ly-don-hang-dang-xu-ly" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Đang xử lý</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= _WEB_ROOT ?>/admin/quan-ly-don-hang-thanh-cong" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Thành công</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= _WEB_ROOT ?>/admin/quan-ly-don-hang-da-huy" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Đã hủy</p>
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->


<script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                },
            });
        }
    });
</script>
<!--end::OverlayScrollbars Configure-->