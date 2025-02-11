<div class="header">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand" href="<?= _WEB_ROOT ?>/trang-chu"><img src="<?= _WEB_ROOT ?>/public/assets/images/logo.png"
                    style="width: 120px;" alt></a>

            <div class="box1">
                <div class="search-box1">
                    <form>
                        <input type="text" placeholder="Nhập từ khóa...">
                        <label for class="icon1"><i
                                style=" color: white; -webkit-text-stroke: 1px white;"
                                class="bi bi-search"></i></label>
                    </form>
                </div>
            </div>

            <button class="navbar-toggler" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1"
                id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <a class="navbar-brand" href="#"><img
                            src="../images/logo.png" style="width: 120px;" alt></a>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" style=" font-weight: bolder;"
                                href="<?= _WEB_ROOT ?>/trang-chu">Trang chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="font-weight: bolder;" href="#">Cửa
                                hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="font-weight: bolder;" href="#">Giới
                                thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="font-weight: bolder;" href="#">Liên
                                lạc
                            </a>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['user'])): ?>
                                <a class="nav-link" href="<?= _WEB_ROOT ?>/gio-hang"><i style="font-size: 25px;"
                                        class="bi bi-cart-fill"></i></a>
                            <?php else: ?>
                                <a class="nav-link" href="#" onclick="return checkLogin();">
                                    <i style="font-size: 25px;" class="bi bi-cart-fill"></i>
                                </a>
                            <?php endif; ?>
                        </li>

                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item">
                            <a class="nav-link" href="<?= _WEB_ROOT ?>/dang-xuat"><i
                                    style="font-size: 25px;"
                                    class="bi bi-person-circle"></i></a>
                            </li>
                        <?php else: ?>
                            <button id="open-login-modal" type="button" class="btn btn-success">Đăng nhập</button>
                        <?php endif; ?>

                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#"><i
                                    style="font-size: 25px;"
                                    class="bi bi-person-circle" href="#"></i></a>
                        </li> -->
                        <!-- <button type="button" class="btn btn-success">Đăng nhập</button> -->

                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>


<!--login modal -->
<div class="login-content" id="login-modal">
    <div class="wrapper">
        <form>
            <span class="close-btn">&times;</span>
            <h1>Đăng nhập</h1>
            <div class="input-box">
                <input type="email" id="email-lg" name="email-lg" placeholder="Email" required>
                <i class="fa-solid fa-user"></i>
                <small></small>
            </div>

            <div class="input-box">
                <input type="password" id="password-lg" name="password-lg" placeholder="Mật khẩu" required>
                <i class="fa-solid fa-lock"></i>
                <small></small>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox">Ghi nhớ tài khoản</label>
                <a href="">Quên mật khẩu</a>
            </div>

            <button type="submit" class="login-btn">Đăng nhập</button>

            <div class="register-link">
                <p>Bạn chưa có tài khoản? <a href="#">Đăng ký</a></p>
            </div>
        </form>
    </div>
</div>
<!-- End login model -->


<!-- register modal -->
<div class="login-content" id="register-modal">
    <div class="wrapper">
        <form>
            <span class="close-btn">&times;</span>
            <h1>Đăng ký</h1>
            <div class="input-box">
                <input type="email" id="email-rg" name="email-rg" placeholder="Email" required>
                <i class="fa-solid fa-user"></i>
                <small></small>
            </div>

            <div class="input-box">
                <input type="password" id="password-rg" name="password-rg" placeholder="Mật khẩu" required>
                <i class="fa-solid fa-lock"></i>
                <small></small>
            </div>

            <div class="input-box">
                <input type="password" id="confirm-rg" name="confirm-rg" placeholder="Xác nhận mật khẩu" required>
                <i class="fa-solid fa-lock"></i>
                <small></small>
            </div>

            <button type="submit" class="login-btn">Đăng ký</button>

        </form>
    </div>
</div>
<!-- end register modal -->


<script>
    function checkLogin() {
        alert("Vui lòng đăng nhập!");
        return false; // Ngăn không cho chuyển trang
    }

    document.addEventListener("DOMContentLoaded", function() {
        const loginModal = document.getElementById("login-modal");
        const registerModal = document.getElementById("register-modal");
        const loginBtn = document.getElementById("open-login-modal"); // Nút đăng nhập
        const closeBtns = document.querySelectorAll(".close-btn"); // Nút đóng modal
        const switchToRegister = document.querySelector("#login-modal .register-link a"); // Chuyển sang đăng ký
        const loginForm = document.querySelector("#login-modal form");
        const registerForm = document.querySelector("#register-modal form");

        // Hiển thị modal đăng nhập khi nhấn nút "Đăng nhập"
        loginBtn.addEventListener("click", function() {
            loginModal.classList.add("active");
        });

        // Ẩn cả hai modal khi nhấn nút đóng
        closeBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                loginModal.classList.remove("active");
                registerModal.classList.remove("active");
            });
        });

        // Chuyển từ đăng nhập sang đăng ký
        switchToRegister.addEventListener("click", function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
            loginModal.classList.remove("active");
            registerModal.classList.add("active");
        });

        // Ẩn modal khi nhấn ra ngoài vùng modal
        window.addEventListener("click", function(e) {
            if (e.target === loginModal) {
                loginModal.classList.remove("active");
            }
            if (e.target === registerModal) {
                registerModal.classList.remove("active");
            }
        });

        // Gửi AJAX khi submit form đăng nhập
        loginForm.addEventListener("submit", function(event) {
            event.preventDefault();

            let formData = new FormData(loginForm);

            fetch("<?= _WEB_ROOT ?>/dang-nhap", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload(); // Đăng nhập thành công => Load lại trang
                        alert(data.message);
                    } else {
                        alert(data.message); // Hiển thị lỗi
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        });

        // Gửi AJAX khi submit form đăng ký
        registerForm.addEventListener("submit", function(event) {
            event.preventDefault();

            let formData = new FormData(registerForm);

            fetch("<?= _WEB_ROOT ?>/dang-ky", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Chuyển từ modal đăng ký sang modal đăng nhập
                        registerModal.classList.remove("active");
                        loginModal.classList.add("active");
                    } else {
                        alert(data.message); // Hiển thị lỗi
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        });
    });
</script>