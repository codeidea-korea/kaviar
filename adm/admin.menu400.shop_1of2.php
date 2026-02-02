<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP || $theme_type != 'shop') return;

$menu['menu400'] = array (
    array('400000', '쇼핑몰관리', G5_ADMIN_URL.'/shop_admin/', 'shop_config'),    
	array('400010', '쇼핑몰현황', G5_ADMIN_URL.'/shop_admin/', 'shop_index'),
    array('400100', '쇼핑몰설정', G5_ADMIN_URL.'/shop_admin/configform.php', 'scf_config'),
	
    array('400400', '주문내역', G5_ADMIN_URL.'/shop_admin/orderlist.php', 'scf_order', 1),
    array('400440', '개인결제관리', G5_ADMIN_URL.'/shop_admin/personalpaylist.php', 'scf_personalpay', 1),
    array('400200', '분류관리', G5_ADMIN_URL.'/shop_admin/categorylist.php', 'scf_cate'),
    array('400300', '상품관리', G5_ADMIN_URL.'/shop_admin/itemlist.php', 'scf_item'),
    array('400660', '상품문의', G5_ADMIN_URL.'/shop_admin/itemqalist.php', 'scf_item_qna'),
    array('400650', '상품후기', G5_ADMIN_URL.'/shop_admin/itemuselist.php', 'scf_ps'), //인태 - 타이틀 변경
	array('400651', '1:1문의', G5_ADMIN_URL.'/shop_admin/itemonelist.php', 'scf_ps'),
    array('400620', '상품재고관리', G5_ADMIN_URL.'/shop_admin/itemstocklist.php', 'scf_item_stock'),
    array('400610', '상품유형관리', G5_ADMIN_URL.'/shop_admin/itemtypelist.php', 'scf_item_type'),
    array('400500', '상품옵션재고관리', G5_ADMIN_URL.'/shop_admin/optionstocklist.php', 'scf_item_option'),
    array('400800', '쿠폰관리', G5_ADMIN_URL.'/shop_admin/couponlist.php', 'scf_coupon'),
    array('400810', '쿠폰존관리', G5_ADMIN_URL.'/shop_admin/couponzonelist.php', 'scf_coupon_zone'),
    array('400750', '추가배송비관리', G5_ADMIN_URL.'/shop_admin/sendcostlist.php', 'scf_sendcost', 1),
    array('400410', '미완료주문', G5_ADMIN_URL.'/shop_admin/inorderlist.php', 'scf_inorder', 1),

	array('400401', '반품/환불/교환', G5_ADMIN_URL.'/shop_admin/orderreturnlist.php', 'orderreturnlist'),
	array('400402', '주문에러리스트', G5_ADMIN_URL.'/shop_admin/order_error_list.php', 'order_error_list', 1),

	//인태 - 추가
	array('400900', '쇼핑몰 추가설정', G5_ADMIN_URL.'/shop_admin/my/config_form.php', 'scf_config'),
	array('400901', '상품유형 설정', G5_ADMIN_URL.'/shop_admin/my/itemtype.php', 'cf_itemtype'),
	array('400902', $store_label.'관리', G5_ADMIN_URL.'/shop_admin/my/storelist.php', 'shop_store'),
	array('400903', '기업코드 관리', G5_ADMIN_URL.'/shop_admin/my/membercode.php', 'membercode'),
	array('400904', '출고지 관리', G5_ADMIN_URL.'/shop_admin/my/shippinglocation.php', 'shipping'),
);