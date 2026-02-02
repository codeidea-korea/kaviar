<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined("_ORDERINQUIRY_")) exit; // 개별 페이지 접근 불가

// 테마에 orderinquiry.sub.php 있으면 include
if(defined('G5_THEME_MSHOP_PATH')) {
    $theme_inquiry_file = file_exists(G5_THEME_MSHOP_PATH.'/orderinquiry.sub.php') ? G5_THEME_MSHOP_PATH.'/orderinquiry.sub.php' : G5_THEME_SHOP_PATH.'/orderinquiry.sub.php';
    if(is_file($theme_inquiry_file)) {
        include_once($theme_inquiry_file);
        return;
        unset($theme_inquiry_file);
    }
}

//datepicker - https://fengyuanchen.github.io/datepicker/
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_THEME_JS_URL.'/my/datepicker/datepicker.css').'">', 0);
add_javascript('<script src="'.get_url(G5_THEME_JS_URL.'/my/datepicker/datepicker.js').'"></script>', 2);
add_javascript('<script src="'.G5_THEME_JS_URL.'/my/datepicker/datepicker.ko-KR.js"></script>', 2);
?>


<?php if (!$limit) { ?>총 <?php echo $cnt; ?> 건<?php } ?>


<div id="sod_search" class="none">
	<div class="title">최근 <?=$default['shop_type']?'예약':'주문'?>내역</div>
	<form name="" action="" method="post">
	<div class="search-form">
		<div class="frmSet">
			<div class="g1">
				<input type="text" name="" class="datepicker">
				<span>~</span>
				<input type="text" name="" class="datepicker">
			</div>
			<div class="g2">
				<div class="_btn/md px13">7일</div>
				<div class="_btn/md/blue px13">10일</div>
				<div class="_btn/md px13">30일</div>
			</div>
		</div>
		<button type="" class="_btn/blue/line/lg w-full">검색</button>
	</div>
	</form>	
</div>


<div id="sod_inquiry">
    <ul>
        <?php
        $sql = " select *,
                    (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
                   from {$g5['g5_shop_order_table']}
                  where mb_id = '{$member['mb_id']}'
                  order by od_id desc
                  $limit ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {

            // 주문상품
            $sql = " select it_name, ct_option, it_id
                        from {$g5['g5_shop_cart_table']}
                        where od_id = '{$row['od_id']}'
                        order by io_type, ct_id
                        limit 1 ";
            $ct = sql_fetch($sql);
            $ct_name = get_text($ct['it_name']).' '.get_text($ct['ct_option']);

			$ct_type = $ct['it_type'];

            $sql = " select count(*) as cnt
                        from {$g5['g5_shop_cart_table']}
                        where od_id = '{$row['od_id']}' ";
            $ct2 = sql_fetch($sql);
            if($ct2['cnt'] > 1)
                $ct_name .= ' 외 '.($ct2['cnt'] - 1).'건';

            switch($row['od_status']) {
                case '주문':
                    $od_status = '<span class="status_01">입금확인중</span>';
                    break;
                case '입금':
                    $od_status = '<span class="status_02">입금완료</span>';
                    break;
                case '준비':
                    $od_status = '<span class="status_03">'.($default['shop_type']?'예약완료':'상품준비중').'</span>';
                    break;
                case '배송':
                    $od_status = '<span class="status_04">상품배송</span>';
                    break;
                case '완료':
                    $od_status = $default['shop_type'] ? '<a href="'.shop_item_url($ct['it_id']).'#v_review" class="_btn">후기작성</a>' : '<span class="status_05">배송완료</span>';
                    break;
                default:
                    $od_status = '<span class="status_06">'.($default['shop_type']?'예약취소':'주문취소').'</span>';
                    break;
            }

            $od_invoice = '';
            if($row['od_delivery_company'] && $row['od_invoice'])
                $od_invoice = '<span class="inv_inv"><i class="fa fa-truck" aria-hidden="true"></i> <strong>'.get_text($row['od_delivery_company']).'</strong> '.get_text($row['od_invoice']).'</span>';

            $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

			// 총계 = 주문상품금액합계 + 배송비 - 상품할인 - 결제할인 - 배송비할인
			$tot_price = $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']
                        - $row['od_cart_coupon'] - $row['od_coupon'] - $row['od_send_coupon']
                        - $row['od_cancel_price'];
        ?>

        <li>
            <div class="inq_head">
				<div class="inq_id">
					[<?=$default['shop_type']?'예약번호':'주문번호'?> <?php echo $row['od_id']; ?>]<?=$ct['ct_id']?>
					<a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>" class="idtime_link"><?=$default['shop_type']?'예약상세':'주문상세'?></a>
				</div>
				<div class="inquiry_idtime"><?php echo substr($row['od_time'],2,25); ?></div>
            </div>
			<div class="inq_con">
				<div class="inq_name"><?php echo $ct_name; ?></div>
				<div class="inq_price"><?=display_price($tot_price)?><?php// echo display_price($row['od_receipt_price']); ?></div>
			</div>
            <div class="inq_bottom">
				<?php echo $od_status; ?>
				<!--<a href="#" class="_btn/lg">재주문</a>-->
            </div>
        </li>

        <?php
        }

        if ($i == 0)
            echo '<li class="empty_list">'.($default['shop_type']?'예약':'주문').' 내역이 없습니다.</li>';
        ?>
    </ul>
</div>
