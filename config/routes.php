<?php
$routes['default_controller'] = 'home';
// Đường dẫn ảo => Đường dẫn thật
$routes['san-pham'] = 'product/index';
$routes['trang-chu'] = 'home';
$routes['chi-tiet-san-pham/ma-san-pham-(\d+)'] = 'product/detail/$1';
$routes['them-vao-gio-hang'] = 'cart/addCart';
$routes['dang-nhap'] = 'user/login';
$routes['dang-ky'] = 'user/register';
$routes['dang-xuat'] = 'user/logout';
$routes['gio-hang'] = 'cart/index';
$routes['thanh-toan'] = 'order/index';
$routes['thong-tin-ca-nhan'] = 'user/profile';
$routes['cua-hang'] = 'product/index';
$routes['cua-hang/(\d+)'] = 'product/productByCategory/$1';


$routes['admin/thong-ke'] = 'admin/dashboard/index';
$routes['admin/quan-ly-danh-muc'] = 'admin/category/index';
$routes['admin/quan-ly-san-pham'] = 'admin/product/index';
$routes['admin/quan-ly-nhan-vien'] = 'admin/user/staff';
$routes['admin/quan-ly-khach-hang'] = 'admin/user/client';
$routes['admin/quan-ly-don-hang-dang-xu-ly'] = 'admin/order/processing';
$routes['admin/quan-ly-don-hang-thanh-cong'] = 'admin/order/success';
$routes['admin/quan-ly-don-hang-da-huy'] = 'admin/order/cancel';