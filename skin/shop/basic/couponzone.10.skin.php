<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/skin.css">', 0);
?>

<section class="couponzone_list">
    <h2 class="fs14 fw600 mb15">다운로드 쿠폰</h2>

    <?php
    $sql = " select * $sql_common and cz_type = '0' $sql_order ";
    $result = sql_query($sql);

    $coupon = '';
    $coupon_info_class = '';

    for($i=0; $row=sql_fetch_array($result); $i++) {
        /*if(!$row['cz_file'])
            continue;

        $img_file = G5_DATA_PATH.'/coupon/'.$row['cz_file'];
        if(!is_file($img_file))
            continue;*/ //인태 - 쿠폰 이미지 없어도 출력

        $subj = get_text($row['cz_subject']);

        switch($row['cp_method']) {
            case '0':
                $row3 = get_shop_item($row['cp_target'], true);
				$cp_target = '개별상품할인';
                $cp_link ='<a href="'.shop_item_url($row3['it_id']).'" target="_blank">'.get_text($row3['it_name']).'</a>';
                $coupon_info_class = 'cp_2';
                break;
            case '1':
                $sql3 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
                $row3 = sql_fetch($sql3);
                $cp_target = '카테고리할인';
                $cp_link = '<a href="'.shop_category_url($row3['ca_id']).'" target="_blank">'.get_text($row3['ca_name']).'</a>';
                $coupon_info_class = 'cp_1';
                break;
            case '2':
                $cp_link = $cp_target = '주문금액할인';
                $coupon_info_class = 'cp_3';
                break;
            case '3':
                $cp_link = $cp_target = '배송비할인';
                $coupon_info_class = 'cp_4';
                break;
        }

        // 다운로드 쿠폰인지
        $disabled = '';
        if(is_coupon_downloaded($member['mb_id'], $row['cz_id']))
            $disabled = ' disabled';

        // $row['cp_type'] 값이 있으면 % 이며 없으면 원 입니다.
        $print_cp_price = $row['cp_type'] ? $row['cp_price'].' %' : number_format($row['cp_price']).' 원';

		$coupon .= '<li>'.PHP_EOL;
			$coupon .= '<div class="cp_inner">'.PHP_EOL;
				$coupon .= '<div class="coupon_tit">'.$subj.'</div>';
				$coupon .= '<p class="cp_evt">'.$print_cp_price.'</p>'.PHP_EOL;
				$coupon .= '<button type="button" class="coupon_download'.$disabled.'" data-cid="'.$row['cz_id'].'">쿠폰다운로드</button>';
			$coupon .= '</div>'.PHP_EOL;
			$coupon .= '<div class="cp_cnt">'.PHP_EOL;
				$coupon .= '<div class="coupon_target">';
					$coupon .= $row['cp_method'] == 0 || $row['cp_method'] == 1 ? '<button class="coupon_info_btn">'.$cp_target.'</button>' : $cp_target;
					if($row['cp_method'] == 0 || $row['cp_method'] == 1) {
						$coupon .= '<div class="coupon_info">';
							$coupon .= '<h4>'.$cp_target.'</h4>';
							$coupon .= '<ul>';
								$coupon .= '<li>적용 : '.$cp_link.'</li>';
								if( $row['cp_minimum'] ){   // 쿠폰에 최소주문금액이 있다면
									$coupon .= '<li>최소주문금액 : <span class="cp_evt"><b>'.number_format($row['cp_minimum']).'</b>원</span></li>';
								}
							$coupon .= '</ul>';
							$coupon .= '<button class="coupon_info_cls"><span class="sound_only">닫기</span></button>';
						$coupon .= '</div>';
					}
				$coupon .= '</div>';
				$coupon .= '<div class="coupon_date">다운로드 후 '.number_format($row['cz_period']).'일</div>';
			$coupon .= '</div>'.PHP_EOL;
        $coupon .= '</li>'.PHP_EOL;
    }

    if($coupon)
        echo '<ul>'.PHP_EOL.$coupon.'</ul>'.PHP_EOL;
    else
        echo '<p class="empty_list">사용할 수 있는 쿠폰이 없습니다.</p>';
    ?>
</section>

<section class="couponzone_list" id="point_coupon">
	<h2 class="fs14 fw600 mb15">
		포인트 쿠폰
		<p class="mt5 fs12 fw400 color-gray">보유하신 <?php echo $default['de_admin_company_name']; ?> 회원 포인트를 쿠폰으로 교환하실 수 있습니다.</p>
	</h2>
    <?php
    $sql = " select * $sql_common and cz_type = '1' $sql_order ";
    $result = sql_query($sql);

    $coupon = '';
    $coupon_info_class = '';

    for($i=0; $row=sql_fetch_array($result); $i++) {

        $subj = get_text($row['cz_subject']);

        switch($row['cp_method']) {
            case '0':
                $row3 = get_shop_item($row['cp_target'], true);
				$cp_link = '<a href="'.shop_item_url($row3['it_id']).'" target="_blank">'.get_text($row3['it_name']).'</a>';
                $cp_target = '개별상품할인';
                $coupon_info_class = 'cp_2';
                break;
            case '1':
                $sql3 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
                $row3 = sql_fetch($sql3);
                $cp_link = '<a href="'.shop_category_url($row3['ca_id']).'" target="_blank">'.get_text($row3['ca_name']).'</a>';
                $cp_target = '카테고리할인';
                $coupon_info_class = 'cp_1';
                break;
            case '2':
                $cp_link = $cp_target = '주문금액할인';
                $coupon_info_class = 'cp_3';
                break;
            case '3':
                $cp_link = $cp_target = '배송비할인';
                $coupon_info_class = 'cp_4';
                break;
        }

        // 다운로드 쿠폰인지
        $disabled = '';
        if(is_coupon_downloaded($member['mb_id'], $row['cz_id']))
            $disabled = ' disabled';

        // $row['cp_type'] 값이 있으면 % 이며 없으면 원 입니다.
        $print_cp_price = $row['cp_type'] ? '<b>'.$row['cp_price'].'</b> %' : '<b>'.number_format($row['cp_price']).'</b> 원';

        $coupon .= '<li>'.PHP_EOL;
			$coupon .= '<div class="cp_inner">'.PHP_EOL;
				$coupon .= '<div class="coupon_tit">'.$subj.'</div>';
				$coupon .= '<p class="cp_evt">'.$print_cp_price.'</p>'.PHP_EOL;
				$coupon .= '<button type="button" class="coupon_download coupon_point'.$disabled.'" data-cid="'.$row['cz_id'].'">포인트 '.number_format($row['cz_point']).'점 차감</button>';
			$coupon .= '</div>'.PHP_EOL;

			$coupon .= '<div class="cp_cnt">'.PHP_EOL;
				$coupon .= '<div class="coupon_target">'.PHP_EOL;
					$coupon .= $row['cp_method'] == 0 || $row['cp_method'] == 1 ? '<button class="coupon_info_btn">'.$cp_target.'</button>' : $cp_target;					
					if($row['cp_method'] == 0 || $row['cp_method'] == 1) {
						$coupon .= '<div class="coupon_info">';
							$coupon .= '<h4>'.$cp_target.'</h4>';
							$coupon .= '<ul>';
								$coupon .= '<li>적용 : '.$cp_link.'</li>';
								if( $row['cp_minimum'] ){   // 쿠폰에 최소주문금액이 있다면
									$coupon .= '<li>최소주문금액 : <span class="cp_evt"><b>'.number_format($row['cp_minimum']).'</b>원</span></li>';
								}
							$coupon .= '</ul>';
							$coupon .= '<button class="coupon_info_cls"><span class="sound_only">닫기</span></button>';
						$coupon .= '</div>';
					}			
				$coupon .= '</div>'.PHP_EOL;
				$coupon .= '<div class="coupon_date"><span class="sound_only">기한</span>다운로드 후 '.number_format($row['cz_period']).'일</div>'.PHP_EOL;			
			$coupon .= '</div>'.PHP_EOL;
        $coupon .= '</li>'.PHP_EOL;
    }

    if($coupon)
        echo '<ul>'.PHP_EOL.$coupon.'</ul>'.PHP_EOL;
    else
        echo '<p class="no_coupon">사용할 수 있는 쿠폰이 없습니다.</p>';
    ?>
</section>

<script>
$(function (){
	$(".coupon_info_btn").on("click", function() {
		$(this).parent().children(".coupon_info").show();
    });
    $(".coupon_info_cls").on("click", function() {
        $(".coupon_info").hide();
    });
    // 쿠폰 정보창 닫기
    $(document).mouseup(function (e){
        var container = $(".coupon_info");
        if( container.has(e.target).length === 0)
        container.hide();
    });
});
</script>