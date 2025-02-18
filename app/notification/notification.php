<?php
$title = $mess = $type = '';

if (!empty($_SESSION['noti'])) {
    $title = $_SESSION['noti']['title'] ?? '';
    $mess = $_SESSION['noti']['mess'] ?? '';
    $type = $_SESSION['noti']['type'] ?? '';
    unset($_SESSION['noti']);
}
?>
<script>
    const noti = <?php echo json_encode([
        'title' => $title,
        'mess'  => $mess,
        'type'  => $type
    ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    console.log('Giá trị của noti:', noti); // Debug: Kiểm tra dữ liệu nhận được

    if (Object.values(noti).some(value => value && value.trim() !== '')) {
        document.addEventListener("DOMContentLoaded", function () {
            if (typeof notification === 'function') {
                notification({
                    title: noti.title,
                    mess: noti.mess, // Đảm bảo giá trị này không rỗng
                    type: noti.type
                });
            } else {
                console.log('Hàm notification chưa được định nghĩa!');
            }
        });
    } else {
        console.log('Không có noti nào!');
    }
</script>