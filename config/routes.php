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
$routes['thong-tin-ca-nhan'] = 'user/profile';
$routes['cua-hang'] = 'product/index';
$routes['cua-hang/(\d+)'] = 'product/productByCategory/$1';