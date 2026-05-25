<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


require_once(G5_SHOP_PATH.'/settle_'.$default['de_pg_service'].'.inc.php');
require_once(G5_SHOP_PATH.'/settle_kakaopay.inc.php');

if( $default['de_inicis_lpay_use'] || $default['de_inicis_kakaopay_use'] ){   //이니시스 Lpay 또는 이니시스 카카오페이 사용시
    require_once(G5_SHOP_PATH.'/inicis/lpay_common.php');
}

if(function_exists('is_use_easypay') && is_use_easypay('global_nhnkcp')){  // 타 PG 사용시 NHN KCP 네이버페이 사용이 설정되어 있다면
    require_once(G5_SHOP_PATH.'/kcp/global_nhn_kcp.php');
}

// 결제대행사별 코드 include (스크립트 등)
require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.1.php');

if( $default['de_inicis_lpay_use'] || $default['de_inicis_kakaopay_use'] ){   //이니시스 L.pay 사용시
    require_once(G5_SHOP_PATH.'/inicis/lpay_form.1.php');
}

if(function_exists('is_use_easypay') && is_use_easypay('global_nhnkcp')){  // 타 PG 사용시 NHN KCP 네이버페이 사용이 설정되어 있다면
    require_once(G5_SHOP_PATH.'/kcp/global_nhn_kcp_form.1.php');
}

if($is_kakaopay_use) {
    require_once(G5_SHOP_PATH.'/kakaopay/orderform.1.php');
}
?>

<form name="forderform" id="forderform" method="post" action="<?php echo $order_action_url; ?>" autocomplete="off">
<input type="hidden" name="df_sale_per" value="<?=$default['de_cash_sale']?>">
<input type="hidden" name="de_cash_sale_use" value="<?=$default['de_cash_sale_use']?>">
<div id="sod_frm" class="sod_frm_pc">
	
	<h1 id="_page_title">주문서</h1>
	
	<!-- 주문상품 확인 시작 { -->
	<h3 id="_sod_list_title">주문 상품</h3>
	<ul class="sod_list">
        <?php
        $tot_point = 0;
        $tot_sell_price = 0;

        $goods = $goods_it_id = "";
        $goods_count = -1;

        // $s_cart_id 로 현재 장바구니 자료 쿼리
        $sql = " select a.ct_id,
                        a.it_id,
                        a.it_name,
                        a.ct_price,
                        a.ct_point,
                        a.ct_qty,
                        a.ct_status,
                        a.ct_send_cost,
                        a.it_sc_type,
                        b.ca_id,
                        b.ca_id2,
                        b.ca_id3,
                        b.it_notax,
						a.ct_time_price,
						a.ct_origin_price
                   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
                  where a.od_id = '$s_cart_id'
                    and a.ct_select = '1' ";
        $sql .= " group by a.it_id ";
        $sql .= " order by a.ct_id ";
        $result = sql_query($sql);

        $good_info = '';
        $it_send_cost = 0;
        $it_cp_count = 0;

        $comm_tax_mny = 0; // 과세금액
        $comm_vat_mny = 0; // 부가세
        $comm_free_mny = 0; // 면세금액
        $tot_tax_mny = 0;
		$category_prices = array(); //카테고리 배열추가
        for ($i=0; $row=sql_fetch_array($result); $i++) {
            // 합계금액 계산  SUM(ct_point * ct_qty) as point,
            $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                            SUM(ct_point) as point,
                            SUM(ct_qty) as qty
                        from {$g5['g5_shop_cart_table']}
                        where it_id = '{$row['it_id']}'
                          and od_id = '$s_cart_id' ";
            $sum = sql_fetch($sql);
			
            if (!$goods) {
                //$goods = addslashes($row[it_name]);
                //$goods = get_text($row[it_name]);
                $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $row['it_name']);
                $goods_it_id = $row['it_id'];
            }
            $goods_count++;

            // 에스크로 상품정보
            if($default['de_escrow_use']) {
                if ($i>0)
                    $good_info .= chr(30);
                $good_info .= "seq=".($i+1).chr(31);
                $good_info .= "ordr_numb={$od_id}_".sprintf("%04d", $i).chr(31);
                $good_info .= "good_name=".addslashes($row['it_name']).chr(31);
                $good_info .= "good_cntx=".$row['ct_qty'].chr(31);
                $good_info .= "good_amtx=".$row['ct_price'].chr(31);
            }

            $image = get_it_image($row['it_id'], 80, get_it_height(80));

            $it_name = '<b>' . stripslashes($row['it_name']) . '</b>';
            $it_options = print_item_options($row['it_id'], $s_cart_id);
			if($it_options) {
                $it_name .= '<div class="sod_opt">'.$it_options.'</div>';
            }

            // 복합과세금액
            if($default['de_tax_flag_use']) {
                if($row['it_notax']) {
                    $comm_free_mny += $sum['price'];
                } else {
                    $tot_tax_mny += $sum['price'];
                }
            }

            $point      = $sum['point'];
            $sell_price = $sum['price'];

            // 쿠폰
            $cp_button = '';
			
            if($is_member) {
                $cp_count = 0;
		/*
                $sql = " select cp_id
                            from {$g5['g5_shop_coupon_table']}
                            where (mb_id IN ( '{$member['mb_id']}', '전체회원' )
			  or mb_grade like '%{$member['mb_grade']}%')
                              and cp_start <= '".G5_TIME_YMD."'
                              and cp_end >= '".G5_TIME_YMD."'
                              and cp_minimum <= '$sell_price'
                              and (
                                    ( cp_method = '0' and cp_target = '{$row['it_id']}' )
                                    OR
                                    ( cp_method = '1' and ( cp_target IN ( '{$row['ca_id']}', '{$row['ca_id2']}', '{$row['ca_id3']}' ) ) )
                                  ) ";
		*/						  
			//2025-3-10 버전 주석 후 새로운쿼리 사용					  
		/*		$sql8 = " select cp_id
                            from {$g5['g5_shop_coupon_table']}
                            where (mb_id IN ( '{$member['mb_id']}', '전체회원' )
			  or mb_grade like '%{$member['mb_grade']}%')
                              and cp_start <= '".G5_TIME_YMD."'
                              and cp_end >= '".G5_TIME_YMD."'
                              and cp_minimum <= '$sell_price'
                              and (
                                    ( cp_method = '0' and cp_target = '{$row['it_id']}' ), '{$row['ca_id2']}', '{$row['ca_id3']}' ) ) )
                                  ) ";
		*/					
		
				$sql8 = " select cp_id
                            from {$g5['g5_shop_coupon_table']}
                            where (mb_id IN ( '{$member['mb_id']}', '전체회원' ) or mb_grade like '%{$member['mb_grade']}%')
                              and cp_start <= '".G5_TIME_YMD."'
                              and cp_end >= '".G5_TIME_YMD."'
                              and cp_minimum <= '$sell_price'
                              and (
								( cp_method = '0' and cp_target = '{$row['it_id']}' )
								OR
								( cp_method = '1' and ( cp_target IN ( '{$row['ca_id']}', '{$row['ca_id2']}', '{$row['ca_id3']}' ) ) )
							  ) ";
				
                $res = sql_query($sql8);

                for($k=0; $cp=sql_fetch_array($res); $k++) {
                    if(is_used_coupon($member['mb_id'], $cp['cp_id']))
                        continue;					

                    $cp_count++;
                }

                if($cp_count) {
                    $cp_button = '<div class="flex flex-middle gap5 mt10"><button type="button" class="cp_btn _btn/sm/line/blue">쿠폰적용</button></div>';
                    $it_cp_count++;
                }
            }

            // 배송비
            switch($row['ct_send_cost']) {
                case 1:
                    $ct_send_cost = '착불';
                    break;
                case 2:
                    $ct_send_cost = '무료';
                    break;
                default:
                    $ct_send_cost = '선불';
                    break;
            }

            // 조건부무료
            if($row['it_sc_type'] == 2) {
                $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

                if($sendcost == 0)
                    $ct_send_cost = '무료';
            }
			
			//상품 타입 (배송상품, 예약상품)
			$it_type = get_it_type($row['it_id']);

			if($i==0) {
				echo '<li class="sod_li" style="padding:10px 0;">';					
					echo '<div class="li_name"></div>';
					echo '<div class="li_qty">수량</div>';
					echo '<div class="li_ct_price">금액(정상가)</div>';
					echo '<div class="li_ct_price">할인금액</div>';
					echo '<div class="li_point">적립 포인트</div>';
					echo '<div class="li_dvr">배송비</div>';
					echo '<div class="li_total" style="font-weight:normal">결제 금액</div>';
				echo '</li>';
			}
	
			echo '<li class="sod_li">';
				echo '<input type="hidden" name="it_id['.$i.']"    value="'.$row['it_id'].'">';
				echo '<input type="hidden" name="it_name['.$i.']"  value="'.get_text($row['it_name']).'">';
				echo '<input type="hidden" name="ori_price['.$i.']"  value="'.$row['ct_origin_price'].'">';
				echo '<input type="hidden" name="ori_qty['.$i.']"  value="'.$sum['qty'].'">';
				echo '<input type="hidden" name="it_price['.$i.']" value="'.$sell_price.'">';
				echo '<input type="hidden" name="cp_id['.$i.']" value="">';
				echo '<input type="hidden" name="cp_price['.$i.']" value="0">';
				if($default['de_tax_flag_use']) {
					echo '<input type="hidden" name="it_notax['.$i.']" value="'.$row['it_notax'].'">';
				}
				echo '<div class="li_img sod_img">';
					echo '<a href="'.shop_item_url($row['it_id']).'">'.$image.'</a>';
				echo '</div>';
				echo '<div class="li_name">';
					echo $it_name;
					echo $cp_button;
				echo '</div>';
				echo '<div class="li_qty">';
					echo number_format($sum['qty']);
				echo '</div>';
				echo '<div class="li_ct_price">';
                    //echo number_format($row['ct_origin_price'] * $sum['qty']);
                    echo number_format($sell_price); 
				echo '</div>';
				
			if($row['ct_time_price'] > 0){
				echo '<div>';
					echo '<div class="li_ct_price" id="li_ct_sale_price">';
					if($row['ct_origin_price']-$row['ct_price'] > 0){
						echo '타임특가<br>-'.number_format(($row['ct_origin_price']-$row['ct_price']) * $sum['qty']);
					}else{
						echo '0';
					}
					echo '</div>';
				echo '</div>';
			}else if($member['mb_grade'] == 6){
				echo '<div>';
					echo '<div class="li_ct_price" id="li_ct_sale_price">';
					if($row['ct_origin_price']-$row['ct_price'] > 0){
						echo '임직원할인<br>-'.number_format(($row['ct_origin_price']-$row['ct_price']) * $sum['qty']);
					}else{
						echo '0';
					}
					echo '</div>';
				echo '</div>';
			}else if($row['ct_origin_price']-$row['ct_price'] > 0){
				echo '<div>';
					echo '<div class="li_ct_price" id="li_ct_sale_price">';
						echo '할인<br>-'.number_format(($row['ct_origin_price']-$row['ct_price']) * $sum['qty']);
					echo '</div>';
				echo '</div>';
			}else{
				echo '<div>';
					echo '<div class="li_ct_price" id="li_ct_sale_price">0</div>';
				echo '</div>';
			}
				
				echo '<div class="li_point">';
                    echo number_format($point * $row['ct_qty'] );
                    $tot_point_price = $point * $row['ct_qty'];
				echo '</div>';
				echo '<div class="li_dvr">';
					echo $ct_send_cost;
				echo '</div>';
				echo '<div class="li_total">';
					echo '<span id="sell_price_'.$i.'" class="total_prc">'.number_format($sell_price).'</span>';
				echo '</div>';
			echo '</li>';
			
		
			$category = $row['ca_id'];

	
			// 카테고리가 이미 배열에 있으면 가격을 더하고, 없으면 새로 추가
			if (isset($category_prices[$category])) {
				$category_prices[$category] += $sell_price;
			} else {
				$category_prices[$category] = $sell_price;
			}
	
            $tot_point      += $point;
            $tot_sell_price += $sell_price;
			$tot_prices += $row['ct_origin_price'] * $sum['qty'];
        } // for 끝

        if ($i == 0) {
            //echo '<tr><td colspan="7" class="empty_table">장바구니에 담긴 상품이 없습니다.</td></tr>';
            //alert('장바구니가 비어 있습니다(pc).', G5_SHOP_URL.'/cart.php');
			goto_url(G5_SHOP_URL.'/cart.php'); //인태 - 비회원 장바구니 > 주문하기 > 로그인 - 바로 주문페이지로 넘어가면서 장바구니가 비어 있다고 엘럿이 뜨는 문제.
        } else {
            // 배송비 계산
            $send_cost = $it_type ? 0 : get_sendcost($s_cart_id);
			//$send_cost = get_sendcost($s_cart_id);
        }

        // 복합과세처리
        if($default['de_tax_flag_use']) {
            $comm_tax_mny = round(($tot_tax_mny + $send_cost) / 1.1);
            $comm_vat_mny = ($tot_tax_mny + $send_cost) - $comm_tax_mny;
        }
		
		foreach ($category_prices as $category => $total_price) {
			//echo "카테고리: " . $category . ", 총 가격: " . number_format($total_price) . "원\n";
		}

        ?>
	</ul>
	<?php if ($goods_count) $goods .= ' 외 '.$goods_count.'건'; ?>
	<!-- } 주문상품 확인 끝 -->
	<?//if($cp_count){?>
		쿠폰 적용 시, 적립금이 지급되지 않습니다.
	<?//}?>
	
	<div id="_sod_frmCon">
		
		
		<div id="_sod_frm_info">
			<!-- 주문하시는분 & 받으시는분 정보 -->
			<div class="sod_">
				<input type="hidden" name="od_price"    value="<?php echo $tot_sell_price; ?>">
				<input type="hidden" name="org_od_price"    value="<?php echo $tot_sell_price; ?>">
				<input type="hidden" name="cate_od_price"    value="<?php echo $tot_sell_price; ?>">
				<input type="hidden" name="od_send_cost" value="<?php echo $send_cost; ?>">
				<input type="hidden" name="od_send_cost2" value="0">
				<input type="hidden" name="item_coupon" value="0">
				<input type="hidden" name="od_coupon" value="0">
				<input type="hidden" name="od_cash_sale" value="0">
				<input type="hidden" name="od_send_coupon" value="0">
				<input type="hidden" name="od_goods_name" value="<?php echo $goods; ?>">

				<?php
				// 결제대행사별 코드 include (결제대행사 정보 필드)
				require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');

				if($is_kakaopay_use) {
					require_once(G5_SHOP_PATH.'/kakaopay/orderform.2.php');
				}
				?>

				<!-- 주문하시는 분 입력 시작 { -->
				<?php if(!$it_type) { ?>
				<section id="sod_frm_orderer" class="">
					<h2 class="title">주문하시는 분</h2>			
					<?php
					//주문자 정보
					if ($is_member) {
						echo '<div id="sod_orderer_info">';
							echo '<ul class="formContainer gap20">';
								echo '<li>';
									echo '<div class="label">보내는 분</div>';
									echo get_text($member['mb_name']);
								echo '</li>';
								echo '<li>';
									echo '<div class="label">주소</div>';
									echo $member['mb_addr1'] && $member['mb_addr1'] ? $member['mb_addr1'].$member['mb_addr2'].$member['mb_addr3'].$member['mb_jibeon'] : '<span class="color-gray">주소 정보가 없습니다.</span>';
								echo '</li>';
								echo '<li>';
									echo '<div class="label">휴대폰</div>';
									echo $member['mb_hp'] ? $member['mb_hp'] : '<span class="color-gray">연락처 정보가 없습니다.</span>';
								echo '</li>';
								echo '<li>';
									echo '<div class="label">이메일</div>';
									echo $member['mb_email'] ? $member['mb_email'] : '<span class="color-gray">이메일 정보가 없습니다.</span>';
								echo '</li>';
							echo '</ul>';							
						echo '</div>';
						echo '<input type="hidden" name="od_name" value="'.get_text($member['mb_name']).'" id="od_name">';
						echo '<input type="hidden" name="od_email" value="'.$member['mb_email'].'" id="od_email">';
					} else {
						echo '<ul class="formContainer gap20">';
							echo '<li>';
								echo '<div class="label">이름</div>';
								echo '<input type="text" name="od_name" value="'.(isset($member['mb_name']) ? get_text($member['mb_name']) : '').'" id="od_name" required class="frm_input required w-full" maxlength="20">';
							echo '</li>';
							echo '<li>';
								echo '<div class="label">비밀번호</div>';
								echo '<input type="password" name="od_pwd" id="od_pwd" required class="frm_input required w-full" maxlength="20" placeholder="영,숫자 3~20자 (주문서 조회시 필요)">';
							echo '</li>';
							echo '<li>';
								echo '<div class="label">이메일</div>';
								echo '<input type="email" name="od_email" value="'.$member['mb_email'].'" id="od_email" required class="frm_input required w-full" size="35" maxlength="100">';
							echo '</li>';					
						echo '</ul>';
					}			
					echo '<input type="hidden" name="od_hp" value="'.get_text($member['mb_hp']).'" id="od_hp">';
					echo '<input type="hidden" name="od_tel" value="'.get_text($member['mb_tel']).'" id="od_tel">';
					echo '<input type="hidden" name="od_zip" value="'.$member['mb_zip1'].$member['mb_zip2'].'" id="od_zip">';
					echo '<input type="hidden" name="od_addr1" value="'.get_text($member['mb_addr1']).'" id="od_addr1">';
					echo '<input type="hidden" name="od_addr2" value="'.get_text($member['mb_addr2']).'" id="od_addr2">';
					echo '<input type="hidden" name="od_addr3" value="'.get_text($member['mb_addr3']).'" id="od_addr3">';
					echo '<input type="hidden" name="od_addr_jibeon" value="'.get_text($member['mb_addr_jibeon']).'">';			
					?>
				</section>
				<?php } else { ?>
				<input type="hidden" name="od_name" value="<?=get_text($member['mb_name'])?>" id="od_name">
				<input type="hidden" name="od_email" value="<?=$member['mb_email']?>" id="od_email">
				<input type="hidden" name="od_hp" value="<?=get_text($member['mb_hp'])?>" id="od_hp">
				<input type="hidden" name="od_tel" value="<?=get_text($member['mb_tel'])?>" id="od_tel">
				<?php } ?>
				<!-- } 주문하시는 분 입력 끝 -->

				<!-- 받으시는 분 입력 시작 { -->
				<section id="sod_frm_taker">
					<h2 class="title"><?=$it_type?'예약자 정보':'배송정보'?></h2>			
					<ul class="formContainer line">
						<?php
						if(!$it_type) {
							$addr_list = '';
							if($is_member) {
								// 배송지 이력
								$sep = chr(30);

								// 주문자와 동일
								$addr_list .= '<label class="radio-wrap"><input type="radio" name="ad_sel_addr" value="same" id="ad_sel_addr_same" checked><span></span>주문자와 동일</label>'.PHP_EOL;

								// 기본배송지
								$sql = " select *
											from {$g5['g5_shop_order_address_table']}
											where mb_id = '{$member['mb_id']}'
											  and ad_default = '1' ";
								$row = sql_fetch($sql);
								if(isset($row['ad_id']) && $row['ad_id']) {
									$val1 = $row['ad_name'].$sep.$row['ad_tel'].$sep.$row['ad_hp'].$sep.$row['ad_zip1'].$sep.$row['ad_zip2'].$sep.$row['ad_addr1'].$sep.$row['ad_addr2'].$sep.$row['ad_addr3'].$sep.$row['ad_jibeon'].$sep.$row['ad_subject'];
									$addr_list .= '<label class="radio-wrap"><input type="radio" name="ad_sel_addr" value="'.get_text($val1).'" id="ad_sel_addr_def"><span></span>기본배송지</label>'.PHP_EOL;
								}

								// 최근배송지
								$sql = " select *
											from {$g5['g5_shop_order_address_table']}
											where mb_id = '{$member['mb_id']}'
											  and ad_default = '0'
											order by ad_id desc
											limit 1 ";
								$result = sql_query($sql);
								for($i=0; $row=sql_fetch_array($result); $i++) {
									$val1 = $row['ad_name'].$sep.$row['ad_tel'].$sep.$row['ad_hp'].$sep.$row['ad_zip1'].$sep.$row['ad_zip2'].$sep.$row['ad_addr1'].$sep.$row['ad_addr2'].$sep.$row['ad_addr3'].$sep.$row['ad_jibeon'].$sep.$row['ad_subject'];
									$val2 = '최근배송지('.($row['ad_subject'] ? get_text($row['ad_subject']) : get_text($row['ad_name'])).')';
									$addr_list .= '<label class="radio-wrap"><input type="radio" name="ad_sel_addr" value="'.get_text($val1).'" id="ad_sel_addr_'.($i+1).'"><span></span>'.$val2.'</label>'.PHP_EOL;
								}
								
								$addr_list .= '<div class="flex flex-middle gap15 mt-6">';
								$addr_list .= '<label class="radio-wrap"><input type="radio" name="ad_sel_addr" value="new" id="od_sel_addr_new"><span></span>신규배송지</label>'.PHP_EOL;
								$addr_list .='<a href="'.G5_SHOP_URL.'/orderaddress.php" id="order_address" class="_btn/small/line/rd4 px8">배송지목록</a>';
								$addr_list .= '</div>';
							} else {
								// 주문자와 동일
								$addr_list .= '<label class="radio-wrap"><input type="checkbox" name="ad_sel_addr" value="same" id="ad_sel_addr_same"><span></span>주문자와 동일</label>'.PHP_EOL;
							}
							echo '<li>';
								echo '<div class="label flex-top">배송지</div>';
								echo '<div class="order_choice_place flex column gap20">';
									echo $addr_list;
								echo '</div>';
							echo '</li>';
							if($is_member) {
								echo '<li>';
									echo '<div class="label">배송지명</div>';
									echo '<div>';
										echo '<input type="text" name="ad_subject" id="ad_subject" class="frm_input w-full" maxlength="20" placeholder="배송지명 입력">';
										echo '<p class="mt10"><label class="checkbox-label"><input type="checkbox" name="ad_default" id="ad_default" value="1"><span></span>기본배송지로 설정</label></p>';
									echo '</div>';
								echo '</li>';
							}
						} else {
							echo '<input type="hidden" name="ad_sel_addr" value="same" id="ad_sel_addr_same">';
						}
						?>

						<li>
							<div class="label">이름</div>
							<input type="text" name="od_b_name" id="od_b_name" required class="frm_input required w-full" maxlength="20" placeholder="공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)">
						</li>
						<li>
							<div class="label">연락처</div>
							<input type="text" name="od_b_hp" id="od_b_hp" required class="frm_input w-full required" required maxlength="20" placeholder="휴대폰번호">
							<input type="hidden" name="od_b_tel" id="od_b_tel">
						</li>
						<?php if(!$it_type) { ?>
						<li>
							<div class="label">주소</div>
							<div class="">
								<div class="adress flex flex-middle gap8">
									<input type="text" name="od_b_zip" id="od_b_zip" required class="frm_input required flex1" size="8" maxlength="6" placeholder="우편번호">
									<button type="button" class="_btn/gray" onclick="win_zip('forderform', 'od_b_zip', 'od_b_addr1', 'od_b_addr2', 'od_b_addr3', 'od_b_addr_jibeon');">주소 검색</button>
								</div>
								<p class="mt10">
									<input type="text" name="od_b_addr1" id="od_b_addr1" required class="frm_input frm_address required w-full" size="60" placeholder="기본주소">
								</p>
								<p class="mt10">
									<input type="text" name="od_b_addr2" id="od_b_addr2" class="frm_input frm_address w-full" size="60" placeholder="상세주소">
								</p>
							</div>
							<input type="hidden" name="od_b_addr3" id="od_b_addr3" value="">
							<input type="hidden" name="od_b_addr_jibeon" value="">
						</li>
						<?php if ($default['de_hope_date_use']) { // 배송희망일 사용 ?>
						<li>
							<div class="label">희망배송일</div>
							<div class="flex flex-middle gap10">
								<input type="text" name="od_hope_date" value="" id="od_hope_date" required class="frm_input required w70" size="11" maxlength="10" readonly="readonly"> 이후로 배송 바랍니다.
							</div>
						</li>
						<?php } ?>
						<li>
							<div class="label">배송 메세지</div>
							<div class="flex column gap10">
								<select id="od_memo_sel" class="selectpicker w-full">
									<option value="">배송 메세지 선택</option>
									<option>부재시 경비실에 맡겨주세요.</option>
									<option>부재시 연락주세요.</option>
									<option>부재시 문앞에 놓아주세요.</option>
									<option>배송 전에 연락주세요.</option>
									<option value="input">직접입력</option>
								</select>
								<input type="hidden" name="od_memo" id="od_memo" value="" class="frm_input w-full bg-gray" placeholder="최대 50자 입력 가능합니다.">
							</div>
						</li>
						<?php } ?>
					</ul>
				</section>
				<!-- } 받으시는 분 입력 끝 -->
			</div>
			<!-- //주문하시는분 & 받으시는분 정보 -->

			<!-- 결제정보 입력 시작 { -->	
			<section id="sod_frm_pay">
				<?php
				$oc_cnt = $sc_cnt = 0;
				if($is_member) {
					// 주문쿠폰
					$sql = " select cp_id
								from {$g5['g5_shop_coupon_table']}
								where (mb_id IN ( '{$member['mb_id']}', '전체회원' )
			  or mb_grade like '%{$member['mb_grade']}%')
								  and cp_method = '2'
								  and cp_start <= '".G5_TIME_YMD."'
								  and cp_end >= '".G5_TIME_YMD."'
								  and cp_minimum <= '$tot_sell_price' ";
					$res = sql_query($sql);

					for($k=0; $cp=sql_fetch_array($res); $k++) {
						if(is_used_coupon($member['mb_id'], $cp['cp_id']))
							continue;

						$oc_cnt++;
					}

					if($send_cost > 0) {
						// 배송비쿠폰
						$sql = " select cp_id
									from {$g5['g5_shop_coupon_table']}
									where (mb_id IN ( '{$member['mb_id']}', '전체회원' )
			  or mb_grade like '%{$member['mb_grade']}%')
									  and cp_method = '3'
									  and cp_start <= '".G5_TIME_YMD."'
									  and cp_end >= '".G5_TIME_YMD."'
									  and cp_minimum <= '$tot_sell_price' ";
						$res = sql_query($sql);

						for($k=0; $cp=sql_fetch_array($res); $k++) {
							if(is_used_coupon($member['mb_id'], $cp['cp_id']))
								continue;

							$sc_cnt++;
						}
					}
				}
				?>
				
				
				<!-- 결제수단 & 포인트 사용 -->
				<div id="od_pay_sl">
				
					<?php
					//if (!$default['de_card_point']) echo '<p id="sod_frm_pt_alert"><strong>무통장입금</strong> 이외의 결제 수단으로 결제하시는 경우 포인트를 적립해드리지 않습니다.</p>';
					$multi_settle = 0;
					$checked = '';

					$escrow_title = "";
					if ($default['de_escrow_use']) $escrow_title = "에스크로<br>";

					if ($is_kakaopay_use || $default['de_bank_use'] || $default['de_vbank_use'] || $default['de_iche_use'] || $default['de_card_use'] || $default['de_hp_use'] || $default['de_easy_pay_use'] || $default['de_inicis_lpay_use'] || $default['de_inicis_kakaopay_use']) {

						$temp_point = 0;
						// 회원이면서 포인트사용이면
						if ($is_member && $config['cf_use_point'] && $tot_sell_price > (int)$default['de_settle_order_min_point']) {
							// 포인트 결제 사용 포인트보다 회원의 포인트가 크다면
							if ($member['mb_point'] >= $default['de_settle_min_point']) {
								$temp_point = (int)$default['de_settle_max_point'];

								if($temp_point > (int)$tot_sell_price)
									$temp_point = (int)$tot_sell_price;

								if($temp_point > (int)$member['mb_point'])
									$temp_point = (int)$member['mb_point'];

								$point_unit = (int)$default['de_settle_point_unit'];
								$temp_point = (int)((int)($temp_point / $point_unit) * $point_unit);

								echo '<div id="sod_frm_point">';
									echo '<h3 class="title">포인트</h3>';
									echo '<ul class="_list_info">';
										echo '<li><div class="label">사용포인트 ('.$point_unit.'점단위)</div></li>';
										echo '<li>';
											echo '<div class="w-full flex flex-middle gap10">';
												echo '<input type="hidden" name="max_temp_point" value="'.$temp_point.'">';
												echo '<input type="text" name="od_temp_point" value="0" id="od_temp_point" class="w-200 tright" size="7"> 점';
												echo '<div class="inline-flex flex-middle gap5"><button type="button" id="od_point_btn" class="_btn/sm/rd4">포인트사용</button></div>	';
											echo '</div>';
											
										echo '</li>';
										echo '<li>';
											echo '<div class="label">보유포인트</div>';
											echo '<div>'.display_point($member['mb_point']).'</div>';
										echo '</li>';
										echo '<li>';
											echo '<div class="label">최대 사용 가능 포인트</div>';
											echo '<div id="use_max_point">'.display_point($temp_point).'</div>';
										echo '<li>';
									echo '</ul>';
								echo '</div>';

								$multi_settle++;
							 }
						}
						


						echo '<div id="sod_frm_point">';
							echo '<h3 class="title">결제수단</h3>';
							echo '<ul class="_list_info">';
						
								echo '<li>';
									echo '<div class="label">'.($it_type?'예약할인':'주문할인').' 쿠폰</div>';
									echo '<div class="inline-flex flex-middle gap5"><button type="button" id="od_coupon_btn" class="_btn/sm/rd4">쿠폰적용</button></div>	';
								echo '</li>';

							echo '</ul>';
						echo '</div>';



						echo '<fieldset id="sod_frm_paysel">';							
							echo '<div class="paysel_set_container">';
								echo '<h3 class="title mt40">결제 수단</h3>';
								echo '<ul class="paysel_set gap10">';					
									// 신용카드 사용
									if ($default['de_card_use']) {
										$multi_settle++;
										echo '<li><label class="radio-wrap radio-btn"><input type="radio" id="od_settle_card" name="od_settle_case" value="신용카드" '.$checked.' class="radio-btn"><span>신용카드+간편결제</span></label></li>'.PHP_EOL;
										$checked = '';
									}

									// 계좌이체 사용
									if ($default['de_iche_use']) {
										$multi_settle++;
										echo '<li><label class="radio-wrap radio-btn"><input type="radio" id="od_settle_iche" name="od_settle_case" value="계좌이체" '.$checked.' class="radio-btn"><span>'.$escrow_title.'계좌이체</span></label></li>'.PHP_EOL;
										$checked = '';
									}


									// 무통장입금 사용
									if ($default['de_bank_use']) {
										$multi_settle++;
										echo '<li><label class="radio-wrap radio-btn"><input type="radio" id="od_settle_bank" name="od_settle_case" value="무통장" '.$checked.' class="radio-btn"><span>무통장입금</span></label></li>'.PHP_EOL;
										$checked = '';
									}

									// 카카오페이
									if($is_kakaopay_use) {
										$multi_settle++;
										echo '<li><label class="radio-wrap radio-btn"><input type="radio" id="od_settle_kakaopay" name="od_settle_case" value="KAKAOPAY" '.$checked.' class="radio-btn"><span>KAKAOPAY</span></label></li>'.PHP_EOL;
										$checked = '';
									}

									// 가상계좌 사용
									if ($default['de_vbank_use']) {
										$multi_settle++;
										echo '<li><label class="radio-wrap radio-btn"><input type="radio" id="od_settle_vbank" name="od_settle_case" value="가상계좌" '.$checked.'><span>가상계좌</span>'.$escrow_title.'</label></li>'.PHP_EOL;
										$checked = '';
									}

									// 휴대폰 사용
									if ($default['de_hp_use'] && $is_admin) { //$is_admin - 휴대폰결제 오류로 임시로 관리자만 보이도록 수정
										$multi_settle++;
										echo '<li><label class="radio-wrap radio-btn"><input type="radio" id="od_settle_hp" name="od_settle_case" value="휴대폰" '.$checked.'><span>휴대폰</span></label></li>'.PHP_EOL;
										$checked = '';
									}

									$easypay_prints = array();
									
									// PG 간편결제
									if($default['de_easy_pay_use']) {
										switch($default['de_pg_service']) {
											case 'lg':
												$pg_easy_pay_name = 'PAYNOW';
												break;
											case 'inicis':
												$pg_easy_pay_name = 'KPAY';
												break;
											default:
												$pg_easy_pay_name = 'PAYCO';
												break;
										}

										$multi_settle++;

										if($default['de_pg_service'] === 'kcp' && isset($default['de_easy_pay_services']) && $default['de_easy_pay_services']){
											$de_easy_pay_service_array = explode(',', $default['de_easy_pay_services']);
											if( in_array('nhnkcp_payco', $de_easy_pay_service_array) ){
												$easypay_prints['nhnkcp_payco'] = '<li><label class="radio-wrap"><input type="radio" id="od_settle_nhnkcp_payco" name="od_settle_case" data-pay="payco" value="간편결제"><span></span>PAYCO</label></li>';
											}
											if( in_array('nhnkcp_naverpay', $de_easy_pay_service_array) ){
												$easypay_prints['nhnkcp_naverpay'] = '<li><label class="radio-wrap"><input type="radio" id="od_settle_nhnkcp_naverpay" name="od_settle_case" data-pay="naverpay" value="간편결제" ><span></span>네이버페이</label></li>';
											}
											if( in_array('nhnkcp_kakaopay', $de_easy_pay_service_array) ){
												$easypay_prints['nhnkcp_kakaopay'] = '<li><label class="radio-wrap"><input type="radio" id="od_settle_nhnkcp_kakaopay" name="od_settle_case" data-pay="kakaopay" value="간편결제" ><span></span>카카오페이</label></li>';
											}
										} else {
											$easypay_prints[strtolower($pg_easy_pay_name)] = '<li><label class="radio-wrap"><input type="radio" id="od_settle_easy_pay" name="od_settle_case" value="간편결제"><span></span>'.$pg_easy_pay_name.'</label></li>';
										}

									}

									if( ! isset($easypay_prints['nhnkcp_naverpay']) && function_exists('is_use_easypay') && is_use_easypay('global_nhnkcp') ){
										$easypay_prints['nhnkcp_naverpay'] = '<li><label class="radio-wrap"><input type="radio" id="od_settle_nhnkcp_naverpay" name="od_settle_case" data-pay="naverpay" value="간편결제" ><span></span>네이버페이</label></li>';
									}

									if($easypay_prints) {
										$multi_settle++;
										echo run_replace('shop_orderform_easypay_buttons', implode(PHP_EOL, $easypay_prints), $easypay_prints, $multi_settle);
									}

									//이니시스 Lpay
									if($default['de_inicis_lpay_use']) {
										echo '<li><label class="radio-wrap"><input type="radio" id="od_settle_inicislpay" data-case="lpay" name="od_settle_case" value="lpay" '.$checked.'><span></span>L.pay</label></li>'.PHP_EOL;
										$checked = '';
									}

									//이니시스 카카오페이 
									if(isset($default['de_inicis_kakaopay_use']) && $default['de_inicis_kakaopay_use']) {
										echo '<li><label class="radio-wrap"><input type="radio" id="od_settle_inicis_kakaopay" data-case="inicis_kakaopay" name="od_settle_case" value="inicis_kakaopay" '.$checked.' title="KG 이니시스 카카오페이"><span></span>KG 이니시스 카카오페이<em></em></label></li>'.PHP_EOL;
										$checked = '';
									}
								echo '</ul>';
							echo '</div>'; //paysel_set_container
							
							if ($default['de_bank_use']) {
								// 은행계좌를 배열로 만든후
								$str = explode("\n", trim($default['de_bank_account']));
								if (count($str) <= 1) {
									$bank_account = '<input type="hidden" name="od_bank_account" value="'.$str[0].'">'.$str[0].PHP_EOL;
								} else {
									$bank_account = '<select name="od_bank_account" id="od_bank_account" class="">'.PHP_EOL;
									$bank_account .= '<option value="">선택하십시오.</option>';
									for ($i=0; $i<count($str); $i++) {
										//$str[$i] = str_replace("\r", "", $str[$i]);
										$str[$i] = trim($str[$i]);
										$bank_account .= '<option value="'.$str[$i].'">'.$str[$i].'</option>'.PHP_EOL;
									}
									$bank_account .= '</select>'.PHP_EOL;
								}
								echo '<div>';
									echo '<div id="settle_bank" class="p20 py10 border-1 rd5 mt10" style="display:none">';
										echo '<dl class="list_dl">';
											echo '<dt class="w-full">'.$bank_account.'</dt>';
											echo '<dd style="width:0"></dd>';
											echo '<dt>입금자명</dt>';
											echo '<dd><input type="text" name="od_deposit_name" id="od_deposit_name" size="10" maxlength="20"></dd>';
										echo '</dl>';
									echo '</div>';
								echo '</div>';
							}
						
						echo '</fieldset>'; //sod_frm_paysel
					}

					if ($multi_settle == 0)
						echo '<p>결제할 방법이 없습니다.<br>운영자에게 알려주시면 감사하겠습니다.</p>';
					?>
				</div>
			</section>
			<!-- } 결제 정보 입력 끝 -->
		</div>

		<!-- 주문상품 합계 시작 { -->
		<div id="sod_frm_tot">
			<div class="inner_box">

				<ul class="_list_info line">
					<li>
						<div class="label">주문 금액</div>
						<p><?=number_format($tot_sell_price);?> 원</p>
					</li>
					<!-- <li>
						<div class="label">주문할인</div>
						<p><span id="ct_tot_coupon">0</span> 원</p>
					</li> -->
					<?php if(!$it_type) { ?>
					<li>
						<div class="label">배송비</div>
						<p><?=number_format($send_cost)?> 원</p>
					</li>
					<?php } ?>
					<li class="total">
						<div class="label bold">총계</div>
						<?php $tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비 ?>					
						<p><span id="ct_tot_price"><?=number_format($tot_price)?></span> 원</p>
					</li>
				</ul>
			</div>

			<div class="inner_box mt20">
				<!-- 결제정보 -->
				<div id="pay_info">
					<div class="fs14 fw600 pb15 border-bottom ">결제 정보</div>
					<ul class="_list_info line">
						<?php if($oc_cnt > 0) {
							/*
							echo '<li>';
								echo '<div class="label">'.($it_type?'예약할인':'주문할인').' 쿠폰</div>';
								echo '<div class="inline-flex flex-middle gap5"><button type="button" id="od_coupon_btn" class="_btn/sm/rd4">쿠폰적용</button></div>	';
							echo '</li>';
							*/
							echo '<li>';
								echo '<div class="label">주문할인금액</div>';
								echo '<div>';
									echo '<strong id="od_cp_price">0</strong> 원';
									echo '<input type="hidden" name="od_cp_id" value="">';
								echo '</div>';
							echo '</li>';
						
							
							
						}
						if($default['de_cash_sale_use'] > 0){

							echo '<li id="cash_price" style="display:none">';
								echo '<div class="label">현금할인금액</div>';
								echo '<div>';
									echo '<strong id="od_cash_price">0</strong> 원';
								echo '</div>';
							echo '</li>';
						}
						if(!$it_type) {
							if($sc_cnt > 0) {
								echo '<li>';
									echo '<div class="label">배송비할인 쿠폰</div>';
									echo '<div class="inline-flex flex-middle gap5"><button type="button" id="sc_coupon_btn" class="_btn/sm/rd4">쿠폰적용</button></div>';
								echo '</li>';
								echo '<li>';
									echo '<div class="label">배송비할인금액</div>';
									echo '<div>';
										echo '<strong id="sc_cp_price">0</strong> 원';
										echo '<input type="hidden" name="sc_cp_id" value="">';
									echo '</div>';
								echo '</li>';
							}
							echo '<li>';
								echo '<div class="label">사용포인트</div>';
								echo '<div>';
									echo '<strong id="sc_cp_point">0</strong> 원';
									echo '<input type="hidden" name="sc_cp_point_id" value="">';
								echo '</div>';
							echo '</li>';
							echo '<li class="flex-top">';
								echo '<div class="label">';
									echo '추가 배송비';
									echo '<p class="color-gray fs12 fw400">*지역에 따라 추가되는 도선료등의 배송비입니다.</p>';
								echo '</div>';
								echo '<div><strong id="od_send_cost2">0</strong> 원</div>';
							echo '</li>';
						} else { //!$it_type
							echo '<input type="hidden" name="sc_cp_id" value="">';
						}
						echo '<li class="total">';
							echo '<div class="label">총 결제금</div>';
							$tot_price = $tot_sell_price + $send_cost - $point; // 총계 = 주문상품금액합계 + 배송비
							echo '<div id="od_tot_price" class="color-red"><strong class="print_price">'.number_format($tot_price).'</strong> 원</div>';
						echo '</li>';
						?>
					</ul>
				</div>
				<!-- //결제정보 -->
			</div>

			<?php
			// 결제대행사별 코드 include (주문버튼)
			require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.3.php');

			if($is_kakaopay_use) {
				require_once(G5_SHOP_PATH.'/kakaopay/orderform.3.php');
			}
			?>

			<?php
			if ($default['de_escrow_use']) {
				// 결제대행사별 코드 include (에스크로 안내)
				require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.4.php');
			}
			?>
		</div>
		<!-- } 주문상품 합계 끝 -->

	</div>

	

</div>
</form>

<?php
if( $default['de_inicis_lpay_use'] || $default['de_inicis_kakaopay_use'] ){   //이니시스 L.pay 또는 이니시스 카카오페이 사용시
    require_once(G5_SHOP_PATH.'/inicis/lpay_order.script.php');
}
if(function_exists('is_use_easypay') && is_use_easypay('global_nhnkcp')){  // 타 PG 사용시 NHN KCP 네이버페이 사용이 설정되어 있다면
    require_once(G5_SHOP_PATH.'/kcp/global_nhn_kcp_order.script.php');
}
?>


<script>
//magnific-popup
/*$('.pop-modal-adr').magnificPopup({
	type: 'ajax',
	fixedContentPos: true,
	fixedBgPos: true,
	closeOnContentClick: false, 
	closeOnBgClick: false,
	overflowY: 'auto',
	closeBtnInside: true,
});
$(document).on('click', '.modalClose', function (e) {
	e.preventDefault();
	$.magnificPopup.close();
});*/
//배송 메시지 선택시 od_memo
$('#od_memo_sel').change(function (){
	var val = $(this).val();
	if(val == 'input') {
		$('#od_memo').val('');
		$('#od_memo').prop("type", "text");
	} else if(val) {
		$('#od_memo').val(val);
		$('#od_memo').prop("type", "hidden");
	} else {
		$('#od_memo').val('');
		$('#od_memo').prop("type", "hidden");
	}
});
</script>

<script>
var zipcode = "";
var form_action_url = "<?php echo $order_action_url; ?>";

$(function() {
    var $cp_btn_el;
    var $cp_row_el;
	
	var $it_prc2 = $("input[name^=it_price]");
    var $cp_prc2 = $("input[name^=cp_price]");
	var $ori_price2 = $("input[name^=ori_price]");
    var $ori_qty2 = $("input[name^=ori_qty]");
		
    var sell_price2 = tot_cp_price2 = tot_ori_price2 = 0;
    var it_price2, cp_price2

    $it_prc2.each(function(index) {
        it_price2 = parseInt($(this).val());
        cp_price2 = parseInt($cp_prc2.eq(index).val());
		ori_price2 = parseInt($ori_price2.eq(index).val());
		ori_qty2 = parseInt($ori_qty2.eq(index).val());
		tot_ori_price2 += ori_price2 * ori_qty2;
        sell_price2 += it_price2;
        tot_cp_price2 += cp_price2;
    });

	tot_sell_price2 = tot_ori_price2 - (sell_price2 - tot_cp_price2);

    $("#ct_tot_coupon").text(number_format(String(tot_sell_price2)));

	//쿠폰적용 (개별상품할인)
    $(".cp_btn").click(function() {
        $cp_btn_el = $(this);
        $cp_row_el = $(this).closest("li");
        $("#cp_frm").parent('.od_coupon_wrap').remove();
        var it_id = $cp_btn_el.closest("li").find("input[name^=it_id]").val();

        $.post(
            "./orderitemcoupon.php",
            { it_id: it_id,  sw_direct: "<?php echo $sw_direct; ?>" },
            function(data) {
                //$cp_btn_el.after(data);
				$('#sod_frm').append(data);
            }
        );
    });
		
	//쿠폰적용 (개별상품할인) > 적용
    $(document).on("click", ".cp_apply", function() {
        var $el = $(this).closest("tr");
        var cp_id = $el.find("input[name='f_cp_id[]']").val();
        var price = $el.find("input[name='f_cp_prc[]']").val();
        var subj = $el.find("input[name='f_cp_subj[]']").val();
        var sell_price;

        if(parseInt(price) == 0) {
            if(!confirm(subj+"쿠폰의 할인 금액은 "+price+"원입니다.\n쿠폰을 적용하시겠습니까?")) {
                return false;
            }
        }

        // 이미 사용한 쿠폰이 있는지
        var cp_dup = false;
        var cp_dup_idx;
        var $cp_dup_el;
        $("input[name^=cp_id]").each(function(index) {
            var id = $(this).val();

            if(id == cp_id) {
                cp_dup_idx = index;
                cp_dup = true;
                $cp_dup_el = $(this).closest("tr");;

                return false;
            }
        });

        if(cp_dup) {
            var it_name = $("input[name='it_name["+cp_dup_idx+"]']").val();
            if(!confirm(subj+ "쿠폰은 "+it_name+"에 사용되었습니다.\n"+it_name+"의 쿠폰을 취소한 후 적용하시겠습니까?")) {
                return false;
            } else {
                coupon_cancel($cp_dup_el);
                $("#cp_frm").parent('.od_coupon_wrap').remove();
                $cp_dup_el.find(".cp_btn").text("쿠폰적용").focus();
                $cp_dup_el.find(".cp_cancel").remove();
            }
        }

        var $s_el = $cp_row_el.find(".total_price");;
        sell_price = parseInt($cp_row_el.find("input[name^=it_price]").val());
        sell_price = sell_price - parseInt(price);
        if(sell_price < 0) {
            alert("쿠폰할인금액이 상품 주문금액보다 크므로 쿠폰을 적용할 수 없습니다.");
            return false;
        }
        $s_el.text(number_format(String(sell_price)));
        $cp_row_el.find("input[name^=cp_id]").val(cp_id);
        $cp_row_el.find("input[name^=cp_price]").val(price);
		
		// 현재 상품의 포인트 저장하기 (쿠폰 적용 전)
		var original_point = $cp_row_el.find(".li_point").text().trim();
		$cp_row_el.find(".li_point").attr("data-original-point", original_point);
		
		// 포인트 0으로 설정
		$cp_row_el.find(".li_point").html("0");
	
		// 쿠폰 할인 정보 표시 영역 추가
		var $discount_area = $cp_row_el.find("#li_ct_sale_price");
		// 기존 쿠폰 할인 정보가 있으면 제거
		$cp_row_el.find(".coupon_discount_info").remove();
		// 쿠폰 할인 정보 추가
		$discount_area.after('<div class="li_ct_price coupon_discount_info">쿠폰할인: -' + number_format(String(price)) + '</div>');

        // 결제 금액 쿠폰가 반영하여 차감 by ein1.
        $cp_row_el.find("#li_ct_sale_price").parent().siblings('.li_total').find('.total_prc').text(number_format(String(sell_price)));
        
		calculate_total_price();
		$("#cp_frm").parent('.od_coupon_wrap').remove();
		$cp_btn_el.text("변경").focus();
	
	
        calculate_total_price();
        $("#cp_frm").parent('.od_coupon_wrap').remove();
        $cp_btn_el.text("변경").focus();
        if(!$cp_row_el.find(".cp_cancel").length)
            $cp_btn_el.after("<button type=\"button\" class=\"cp_cancel _btn/sm/line\">취소</button>");
    });
	
	//쿠폰적용 (개별상품할인) > 닫기
    $(document).on("click", "#cp_close", function() {
        $("#cp_frm").parent('.od_coupon_wrap').remove();
        $cp_btn_el.focus();
    });
	
	//쿠폰적용 취소
    $(document).on("click", ".cp_cancel", function() {
        coupon_cancel($(this).closest("li"));
        calculate_total_price();
        $("#cp_frm").parent('.od_coupon_wrap').remove();
        $(this).closest("li").find(".cp_btn").text("쿠폰적용").focus();
        $(this).remove();
    });
	
	//쿠폰적용 (주문할인쿠폰)
    $("#od_coupon_btn").click(function() {
		
		var categoryPrices = <?php echo json_encode($category_prices); ?>;
		
        if( $("#od_coupon_frm").parent(".od_coupon_wrap").length ){
            $("#od_coupon_frm").parent(".od_coupon_wrap").remove();
        }
        $("#od_coupon_frm").remove();
        var $this = $(this);
        var price = parseInt($("input[name=org_od_price]").val()) - parseInt($("input[name=item_coupon]").val());
        if(price <= 0) {
            alert('상품금액이 0원이므로 쿠폰을 사용할 수 없습니다.');
            return false;
        }
        $.post(
            "./ordercoupon.php",
            { price: price,
			  category_prices: categoryPrices },
            function(data) {
                //$this.after(data);
				$('#sod_frm').append(data);
            }
        );
    });
	
	//쿠폰적용 (주문할인쿠폰) > 적용
    $(document).on("click", ".od_cp_apply", function() {
        var $el = $(this).closest("tr");
        var cp_id = $el.find("input[name='o_cp_id[]']").val();
        var price = parseInt($el.find("input[name='o_cp_prc[]']").val());
        var subj = $el.find("input[name='o_cp_subj[]']").val();
        var send_cost = $("input[name=od_send_cost]").val();
        var item_coupon = parseInt($("input[name=item_coupon]").val());
        var od_price = parseInt($("input[name=org_od_price]").val()) - item_coupon;

        if(price == 0) {
            if(!confirm(subj+"쿠폰의 할인 금액은 "+price+"원입니다.\n쿠폰을 적용하시겠습니까?")) {
                return false;
            }
        }

        if(od_price - price <= 0) {
            alert("쿠폰할인금액이 주문금액보다 크므로 쿠폰을 적용할 수 없습니다.");
            return false;
        }

        $("input[name=sc_cp_id]").val("");
        $("#sc_coupon_btn").text("쿠폰적용");
        $("#sc_coupon_cancel").remove();

        $("input[name=od_price]").val(od_price - price);
        $("input[name=od_cp_id]").val(cp_id);
        $("input[name=od_coupon]").val(price);
        $("input[name=od_send_coupon]").val(0);
        $("#od_cp_price").text(number_format(String(price)));
        $("#sc_cp_price").text(0);
        calculate_order_price();
        if( $("#od_coupon_frm").parent(".od_coupon_wrap").length ){
            $("#od_coupon_frm").parent(".od_coupon_wrap").remove();
        }
        $("#od_coupon_frm").remove();
        $("#od_coupon_btn").text("변경").focus();
        if(!$("#od_coupon_cancel").length)
            $("#od_coupon_btn").after("<button type=\"button\" id=\"od_coupon_cancel\" class=\"cp_cancel _btn/sm/line\">취소</button>");
    });
	
	//쿠폰적용 (주문할인쿠폰) > 닫기
    $(document).on("click", "#od_coupon_close", function() {
        if( $("#od_coupon_frm").parent(".od_coupon_wrap").length ){
            $("#od_coupon_frm").parent(".od_coupon_wrap").remove();
        }
        $("#od_coupon_frm").remove();
        $("#od_coupon_btn").focus();
    });
	
	//쿠폰적용(주문할인쿠폰) >적용 > 취소
    $(document).on("click", "#od_coupon_cancel", function() {
        var org_price = $("input[name=org_od_price]").val();
        var item_coupon = parseInt($("input[name=item_coupon]").val());
        $("input[name=od_price]").val(org_price - item_coupon);
        $("input[name=sc_cp_id]").val("");
        $("input[name=od_coupon]").val(0);
        $("input[name=od_send_coupon]").val(0);
        $("#od_cp_price").text(0);
        $("#sc_cp_price").text(0);
        calculate_order_price();
        if( $("#od_coupon_frm").parent(".od_coupon_wrap").length ){
            $("#od_coupon_frm").parent(".od_coupon_wrap").remove();
        }
        $("#od_coupon_frm").remove();
        $("#od_coupon_btn").text("쿠폰적용").focus();
        $(this).remove();
        $("#sc_coupon_btn").text("쿠폰적용");
        $("#sc_coupon_cancel").remove();
    });
	
	//쿠폰적용(배송비할인쿠폰)
    $("#sc_coupon_btn").click(function() {
        $("#sc_coupon_frm").parent(".od_coupon_wrap").remove();
        var $this = $(this);
        var price = parseInt($("input[name=od_price]").val());
        var send_cost = parseInt($("input[name=od_send_cost]").val());
        $.post(
            "./ordersendcostcoupon.php",
            { price: price, send_cost: send_cost },
            function(data) {
                //$this.after(data);
				$('#sod_frm').append(data);
            }
        );
    });
	
	//쿠폰적용(배송비할인쿠폰) > 적용
    $(document).on("click", ".sc_cp_apply", function() {
        var $el = $(this).closest("tr");
        var cp_id = $el.find("input[name='s_cp_id[]']").val();
        var price = parseInt($el.find("input[name='s_cp_prc[]']").val());
        
        console.log();
        var subj = $el.find("input[name='s_cp_subj[]']").val();
        var send_cost = parseInt($("input[name=od_send_cost]").val());

        if(parseInt(price) == 0) {
            if(!confirm(subj+"쿠폰의 할인 금액은 "+price+"원입니다.\n쿠폰을 적용하시겠습니까?")) {
                return false;
            }
        }

        $("input[name=sc_cp_id]").val(cp_id);
        $("input[name=od_send_coupon]").val(price);
        $("#sc_cp_price").text(number_format(String(price)));
        calculate_order_price();
        $("#sc_coupon_frm").parent(".od_coupon_wrap").remove();
        $("#sc_coupon_btn").text("변경").focus();
        if(!$("#sc_coupon_cancel").length)
            $("#sc_coupon_btn").after("<button type=\"button\" id=\"sc_coupon_cancel\" class=\"cp_cancel _btn/sm/line\">취소</button>");
    });
	
	//쿠폰적용(배송비할인쿠폰) > 닫기
    $(document).on("click", "#sc_coupon_close", function() {
        $("#sc_coupon_frm").parent(".od_coupon_wrap").remove();
        $("#sc_coupon_btn").focus();
    });
	
	//쿠폰적용(배송비할인쿠폰) > 적용 > 취소
    $(document).on("click", "#sc_coupon_cancel", function() {
        $("input[name=od_send_coupon]").val(0);
        $("#sc_cp_price").text(0);
        calculate_order_price();
        $("#sc_coupon_frm").parent(".od_coupon_wrap").remove();
        $("#sc_coupon_btn").text("쿠폰적용").focus();
        $(this).remove();
    });

    $("#od_b_addr2").focus(function() {
        var zip = $("#od_b_zip").val().replace(/[^0-9]/g, "");
        if(zip == "")
            return false;

        var code = String(zip);

        if(zipcode == code)
            return false;

        zipcode = code;
        calculate_sendcost(code);
    });

    $("#od_settle_bank").on("click", function() {
		var de_cash_sale_use = parseInt($("input[name=de_cash_sale_use]").val());
        $("[name=od_deposit_name]").val( $("[name=od_name]").val() );
        $("#settle_bank").show();
		
		
		if(de_cash_sale_use > 0){
			$("#cash_price").show();
			var df_sale_per = parseInt($("input[name=df_sale_per]").val());
			var od_price = parseInt($("input[name=org_od_price]").val());
			var cash_price = Math.round((od_price * df_sale_per) /100);
			//console.log(od_price);
			//console.log(cash_price);
			$("input[name=od_cash_sale]").val(cash_price);
			$("#od_cash_price").text(number_format(String(cash_price)));
			$("#sc_cp_price").text(0);
			calculate_order_price();
		}
		/*
		var $el = $(this).closest("tr");
        var cp_id = $el.find("input[name='o_cp_id[]']").val();
        var price = parseInt($el.find("input[name='o_cp_prc[]']").val());
        var subj = $el.find("input[name='o_cp_subj[]']").val();
        var send_cost = $("input[name=od_send_cost]").val();
        var item_coupon = parseInt($("input[name=item_coupon]").val());
        var od_price = parseInt($("input[name=org_od_price]").val()) - item_coupon;

        if(price == 0) {
            if(!confirm(subj+"쿠폰의 할인 금액은 "+price+"원입니다.\n쿠폰을 적용하시겠습니까?")) {
                return false;
            }
        }

        if(od_price - price <= 0) {
            alert("쿠폰할인금액이 주문금액보다 크므로 쿠폰을 적용할 수 없습니다.");
            return false;
        }

        $("input[name=sc_cp_id]").val("");
        $("#sc_coupon_btn").text("쿠폰적용");
        $("#sc_coupon_cancel").remove();

        $("input[name=od_price]").val(od_price - price);
        $("input[name=od_cp_id]").val(cp_id);
        $("input[name=od_coupon]").val(price);
        $("input[name=od_send_coupon]").val(0);
        $("#od_cp_price").text(number_format(String(price)));
        $("#sc_cp_price").text(0);
        calculate_order_price();
        if( $("#od_coupon_frm").parent(".od_coupon_wrap").length ){
            $("#od_coupon_frm").parent(".od_coupon_wrap").remove();
        }
        $("#od_coupon_frm").remove();
        $("#od_coupon_btn").text("변경").focus();
        if(!$("#od_coupon_cancel").length)
            $("#od_coupon_btn").after("<button type=\"button\" id=\"od_coupon_cancel\" class=\"cp_cancel _btn/sm/line\">취소</button>");
    });
*/

    });

    $("#od_settle_iche,#od_settle_card,#od_settle_vbank,#od_settle_hp,#od_settle_easy_pay,#od_settle_kakaopay,#od_settle_nhnkcp_payco,#od_settle_nhnkcp_naverpay,#od_settle_nhnkcp_kakaopay,#od_settle_inicislpay,#od_settle_inicis_kakaopay").bind("click", function() {
        $("#settle_bank").hide();

    });

	$("#od_settle_card,#od_settle_vbank,#od_settle_hp,#od_settle_easy_pay,#od_settle_kakaopay,#od_settle_nhnkcp_payco,#od_settle_nhnkcp_naverpay,#od_settle_nhnkcp_kakaopay,#od_settle_inicislpay,#od_settle_inicis_kakaopay").bind("click", function() {
        $("#cash_price").hide();
    });
/*
	$("#od_settle_iche").bind("click", function() {
		var de_cash_sale_use = parseInt($("input[name=de_cash_sale_use]").val());
		if(de_cash_sale_use > 0){
			$("#cash_price").show();
		}
    });
*/
    // 배송지선택
    $("input[name=ad_sel_addr]").on("click", function() {
        var addr = $(this).val().split(String.fromCharCode(30));

        if (addr[0] == "same") {
            gumae2baesong();
        } else {
            if(addr[0] == "new") {
                for(i=0; i<10; i++) {
                    addr[i] = "";
                }
            }

            var f = document.forderform;
            f.od_b_name.value        = addr[0];
            f.od_b_tel.value         = addr[1];
            f.od_b_hp.value          = addr[2];
            f.od_b_zip.value         = addr[3] + addr[4];
            f.od_b_addr1.value       = addr[5];
            f.od_b_addr2.value       = addr[6];
            f.od_b_addr3.value       = addr[7];
            f.od_b_addr_jibeon.value = addr[8];
            f.ad_subject.value       = addr[9];

            var zip1 = addr[3].replace(/[^0-9]/g, "");
            var zip2 = addr[4].replace(/[^0-9]/g, "");

            var code = String(zip1) + String(zip2);

            if(zipcode != code) {
                calculate_sendcost(code);
            }
        }
    });

    // 배송지목록
    $("#order_address").on("click", function() {
        var url = this.href;
        window.open(url, "win_address", "left=100,top=100,width=800,height=600,scrollbars=1");
		//window.open(url, "_blank");
        return false;
    });
});

//인태
<?php if($is_member) { ?>
$(document).ready(function(){
	$("#ad_sel_addr_same").click();
});
<?php } ?>

function coupon_cancel($el)
{
    var $dup_sell_el = $el.find(".total_price");
    var $dup_price_el = $el.find("input[name^=cp_price]");
    var org_sell_price = $el.find("input[name^=it_price]").val();
	
	// 저장된 원래 포인트 가져오기
    var original_point = $el.find(".li_point").attr("data-original-point");
    if(original_point) {
        $el.find(".li_point").html(original_point);
        $el.find(".li_point").removeAttr("data-original-point");
    }
	
    $dup_sell_el.text(number_format(String(org_sell_price)));
    $dup_price_el.val(0);
    $el.find("input[name^=cp_id]").val("");
	
	// 쿠폰 할인 정보 제거
    $el.find(".coupon_discount_info").remove();
}

//포인트 적용
$(document).on("click", "#od_point_btn", function() {
	calculate_total_price();
});
	
function calculate_total_price()
{
    var $it_prc = $("input[name^=it_price]");
    var $cp_prc = $("input[name^=cp_price]");
	var points = $("#od_temp_point").val();
	
    var tot_sell_price = sell_price = tot_cp_price = 0;
    var it_price, cp_price, it_notax;
    var tot_mny = comm_tax_mny = comm_vat_mny = comm_free_mny = tax_mny = vat_mny = 0;
    var send_cost = parseInt($("input[name=od_send_cost]").val());
	
	
	var $it_prc2 = $("input[name^=it_price]");
    var $cp_prc2 = $("input[name^=cp_price]");
	var $ori_price2 = $("input[name^=ori_price]");
    var $ori_qty2 = $("input[name^=ori_qty]");
		
    var sell_price2 = tot_cp_price2 = tot_ori_price2 = 0;
    var it_price2, cp_price2

    $it_prc2.each(function(index) {
        it_price2 = parseInt($(this).val());
        cp_price2 = parseInt($cp_prc2.eq(index).val());
		ori_price2 = parseInt($ori_price2.eq(index).val());
		ori_qty2 = parseInt($ori_qty2.eq(index).val());
		tot_ori_price2 += ori_price2 * ori_qty2;
        sell_price2 += it_price2;
        tot_cp_price2 += cp_price2;
    });

	tot_sell_price2 = tot_ori_price2 - (sell_price2 - tot_cp_price2);

    $("#ct_tot_coupon").text(number_format(String(tot_sell_price2)));
	
	
	
    $it_prc.each(function(index) {
        it_price = parseInt($(this).val());
        cp_price = parseInt($cp_prc.eq(index).val());
        sell_price += it_price;
        tot_cp_price += cp_price;	
    });
	
	tot_sell_price1 = sell_price - tot_cp_price + send_cost;
    tot_sell_price = sell_price - tot_cp_price + send_cost - points;
	
    $("#ct_tot_price").text(number_format(String(tot_sell_price1)));
	$("#od_tot_price").text(number_format(String(tot_sell_price)));

    $("input[name=good_mny]").val(tot_sell_price);
    $("input[name=od_price]").val(sell_price - tot_cp_price);
    $("input[name=item_coupon]").val(tot_cp_price);
    $("input[name=od_coupon]").val(0);
    $("input[name=od_send_coupon]").val(0);
    <?php if($oc_cnt > 0) { ?>
    $("input[name=od_cp_id]").val("");
    $("#od_cp_price").text(0);
    if($("#od_coupon_cancel").length) {
        $("#od_coupon_btn").text("쿠폰적용");
        $("#od_coupon_cancel").remove();
    }
    <?php } ?>
    <?php if($sc_cnt > 0) { ?>
    $("input[name=sc_cp_id]").val("");
    $("#sc_cp_price").text(0);
	
    if($("#sc_coupon_cancel").length) {
        $("#sc_coupon_btn").text("쿠폰적용");
        $("#sc_coupon_cancel").remove();
    }
    <?php } ?>
    //$("input[name=od_temp_point]").val(0);
    <?php if($temp_point > 0 && $is_member) { ?>
    calculate_temp_point();
    <?php } ?>
	$("#sc_cp_point").text(number_format(String(points)));
    calculate_order_price();
}

function calculate_order_price()
{
    var sell_price = parseInt($("input[name=od_price]").val());
    var send_cost = parseInt($("input[name=od_send_cost]").val());
    var send_cost2 = parseInt($("input[name=od_send_cost2]").val());
    var send_coupon = parseInt($("input[name=od_send_coupon]").val());
	var cash_sale = parseInt($("input[name=od_cash_sale]").val());
    var tot_price = sell_price + send_cost + send_cost2 - send_coupon - cash_sale;

    $("input[name=good_mny]").val(tot_price);
    // $("#od_tot_price .print_price").text(number_format(String(tot_price)));
    
    $("#od_tot_price").html('<strong class="print_price">'+number_format(String(tot_price))+'</strong> 원');
    
    <?php if($temp_point > 0 && $is_member) { ?>
    calculate_temp_point();
    <?php } ?>
}

function calculate_temp_point()
{

    var sell_price = parseInt($("input[name=od_price]").val());
    var mb_point = parseInt(<?php echo $member['mb_point']; ?>);
    var max_point = parseInt(<?php echo $default['de_settle_max_point']; ?>);
    var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
    var temp_point = max_point;

    if(temp_point > sell_price)
        temp_point = sell_price;

    if(temp_point > mb_point)
        temp_point = mb_point;

    temp_point = parseInt(temp_point / point_unit) * point_unit;

    $("#use_max_point").text(number_format(String(temp_point))+"점");
    $("input[name=max_temp_point]").val(temp_point);
}

function calculate_sendcost(code)
{
    $.post(
        "./ordersendcost.php",
        { zipcode: code },
        function(data) {
            $("input[name=od_send_cost2]").val(data);
            $("#od_send_cost2").text(number_format(String(data)));

            zipcode = code;

            calculate_order_price();
        }
    );
}

function calculate_tax()
{
    var $it_prc = $("input[name^=it_price]");
    var $cp_prc = $("input[name^=cp_price]");
    var sell_price = tot_cp_price = 0;
    var it_price, cp_price, it_notax;
    var tot_mny = comm_free_mny = tax_mny = vat_mny = 0;
    var send_cost = parseInt($("input[name=od_send_cost]").val());
    var send_cost2 = parseInt($("input[name=od_send_cost2]").val());
    var od_coupon = parseInt($("input[name=od_coupon]").val());
    var send_coupon = parseInt($("input[name=od_send_coupon]").val());
    var temp_point = 0;

    $it_prc.each(function(index) {
        it_price = parseInt($(this).val());
        cp_price = parseInt($cp_prc.eq(index).val());
        sell_price += it_price;
        tot_cp_price += cp_price;
        it_notax = $("input[name^=it_notax]").eq(index).val();
        if(it_notax == "1") {
            comm_free_mny += (it_price - cp_price);
        } else {
            tot_mny += (it_price - cp_price);
        }
    });

    if($("input[name=od_temp_point]").length)
        temp_point = parseInt($("input[name=od_temp_point]").val());

    tot_mny += (send_cost + send_cost2 - od_coupon - send_coupon - temp_point);
    if(tot_mny < 0) {
        comm_free_mny = comm_free_mny + tot_mny;
        tot_mny = 0;
    }

    tax_mny = Math.round(tot_mny / 1.1);
    vat_mny = tot_mny - tax_mny;
    $("input[name=comm_tax_mny]").val(tax_mny);
    $("input[name=comm_vat_mny]").val(vat_mny);
    $("input[name=comm_free_mny]").val(comm_free_mny);
}

function forderform_check(f)
{
    // 재고체크
    var stock_msg = order_stock_check();
    if(stock_msg != "") {
        alert(stock_msg);
        return false;
    }

    errmsg = "";
    errfld = "";
    var deffld = "";

    check_field(f.od_name, "주문하시는 분 이름을 입력하십시오.");
    if (typeof(f.od_pwd) != 'undefined')
    {
        clear_field(f.od_pwd);
        if( (f.od_pwd.value.length<3) || (f.od_pwd.value.search(/([^A-Za-z0-9]+)/)!=-1) )
            error_field(f.od_pwd, "회원이 아니신 경우 주문서 조회시 필요한 비밀번호를 3자리 이상 입력해 주십시오.");
    }
    //check_field(f.od_tel, "주문하시는 분 전화번호를 입력하십시오."); //인태 - 주문자 검사 패스
	//check_field(f.od_hp, "주문하시는 분 연락처를 입력하십시오."); //인태 - 주문자 검사 패스
    //check_field(f.od_addr1, "주소검색을 이용하여 주문하시는 분 주소를 입력하십시오."); //인태 - 주문자 검사 패스
    //check_field(f.od_addr2, " 주문하시는 분의 상세주소를 입력하십시오."); //인태 - 주문자 검사 패스
    //check_field(f.od_zip, ""); //인태 - 주문자 검사 패스

    clear_field(f.od_email);
    if(f.od_email.value=='' || f.od_email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1)
        error_field(f.od_email, "E-mail을 바르게 입력해 주십시오.");
	
	<?php if(!$it_type) { ?>
    if (typeof(f.od_hope_date) != "undefined")
    {
        clear_field(f.od_hope_date);
        if (!f.od_hope_date.value)
            error_field(f.od_hope_date, "희망배송일을 선택하여 주십시오.");
    }
	<?php } ?>

    check_field(f.od_b_name, "받으시는 분 이름을 입력하십시오.");
    //check_field(f.od_b_tel, "받으시는 분 전화번호를 입력하십시오.");
	check_field(f.od_b_hp, "받으시는 분 연락처를 입력하십시오."); //인태 - 연락처 필수로 변경

	<?php if(!$it_type) { ?>
    check_field(f.od_b_addr1, "주소검색을 이용하여 받으시는 분 주소를 입력하십시오.");
    //check_field(f.od_b_addr2, "받으시는 분의 상세주소를 입력하십시오.");
    check_field(f.od_b_zip, "");
	<?php } ?>

	//인태 - 휴대폰 번호 자리수 체크 10자리 이상
	var trans_num = $("input[name=od_b_hp]").val().replace(/-/gi,'');
	if(trans_num.length < 10) {  
		error_field(f.od_b_hp, "받으시는 분 연락처를 바르게 입력해 주십시오.");
		$("input[name=od_b_hp]").focus();
	}


    var od_settle_bank = document.getElementById("od_settle_bank");
    if (od_settle_bank) {
        if (od_settle_bank.checked) {
            check_field(f.od_bank_account, "계좌번호를 선택하세요.");
            check_field(f.od_deposit_name, "입금자명을 입력하세요.");
        }
    }

    // 배송비를 받지 않거나 더 받는 경우 아래식에 + 또는 - 로 대입
    f.od_send_cost.value = parseInt(f.od_send_cost.value);

    if (errmsg)
    {
        alert(errmsg);
        errfld.focus();
        return false;
    }

    var settle_case = document.getElementsByName("od_settle_case");
    var settle_check = false;
    var settle_method = "";

    for (i=0; i<settle_case.length; i++)
    {
        if (settle_case[i].checked)
        {
            settle_check = true;
            settle_method = settle_case[i].value;
            break;
        }
    }
    if (!settle_check)
    {
        alert("결제방식을 선택하십시오.");
        return false;
    }

    var od_price = parseInt(f.od_price.value);
    var send_cost = parseInt(f.od_send_cost.value);
    var send_cost2 = parseInt(f.od_send_cost2.value);
    var send_coupon = parseInt(f.od_send_coupon.value);

    var max_point = 0;
    if (typeof(f.max_temp_point) != "undefined")
        max_point  = parseInt(f.max_temp_point.value);

    var temp_point = 0;
    if (typeof(f.od_temp_point) != "undefined") {
        var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
        temp_point = parseInt(f.od_temp_point.value) || 0;

        if (f.od_temp_point.value)
        {
            if (temp_point > od_price) {
                alert("상품 주문금액<?php if(!$it_type) { ?>(배송비 제외)<?php } ?> 보다 많이 포인트결제할 수 없습니다.");
                f.od_temp_point.select();
                return false;
            }

            if (temp_point > <?php echo (int)$member['mb_point']; ?>) {
                alert("회원님의 포인트보다 많이 결제할 수 없습니다.");
                f.od_temp_point.select();
                return false;
            }

            if (temp_point > max_point) {
                alert(max_point + "점 이상 결제할 수 없습니다.");
                f.od_temp_point.select();
                return false;
            }

            if (parseInt(parseInt(temp_point / point_unit) * point_unit) != temp_point) {
                alert("포인트를 "+String(point_unit)+"점 단위로 입력하세요.");
                f.od_temp_point.select();
                return false;
            }
        }

        // pg 결제 금액에서 포인트 금액 차감
        if(settle_method != "무통장") {
            f.good_mny.value = od_price + send_cost + send_cost2 - send_coupon - temp_point;
        }
    }

    var tot_price = od_price + send_cost + send_cost2 - send_coupon - temp_point;

    if (document.getElementById("od_settle_iche")) {
        if (document.getElementById("od_settle_iche").checked) {
            if (tot_price < 150) {
                alert("계좌이체는 150원 이상 결제가 가능합니다.");
                return false;
            }
        }
    }

    if (document.getElementById("od_settle_card")) {
        if (document.getElementById("od_settle_card").checked) {
            if (tot_price < 1000) {
                alert("신용카드는 1000원 이상 결제가 가능합니다.");
                return false;
            }
        }
    }

    if (document.getElementById("od_settle_hp")) {
        if (document.getElementById("od_settle_hp").checked) {
            if (tot_price < 350) {
                alert("휴대폰은 350원 이상 결제가 가능합니다.");
                return false;
            }
        }
    }

    <?php if($default['de_tax_flag_use']) { ?>
    calculate_tax();
    <?php } ?>

    <?php if($default['de_pg_service'] == 'inicis') { ?>
    if( f.action != form_action_url ){
        f.action = form_action_url;
        f.removeAttribute("target");
        f.removeAttribute("accept-charset");
    }
    <?php } ?>

    // 카카오페이 지불
    if(settle_method == "KAKAOPAY") {
        <?php if($default['de_tax_flag_use']) { ?>
        f.SupplyAmt.value = parseInt(f.comm_tax_mny.value) + parseInt(f.comm_free_mny.value);
        f.GoodsVat.value  = parseInt(f.comm_vat_mny.value);
        <?php } ?>
        getTxnId(f);
        return false;
    }

    var form_order_method = '';

    if( settle_method == "lpay" || settle_method == "inicis_kakaopay" ){      //이니시스 L.pay 또는 이니시스 카카오페이 이면 ( 이니시스의 삼성페이는 모바일에서만 단독실행 가능함 )
        form_order_method = 'samsungpay';
    } else if(settle_method == "간편결제") {
        if(jQuery("input[name='od_settle_case']:checked" ).attr("data-pay") === "naverpay"){
            form_order_method = 'nhnkcp_naverpay';
        }
    }

    if( jQuery(f).triggerHandler("form_sumbit_order_"+form_order_method) !== false ) {
        
        // pay_method 설정
        <?php if($default['de_pg_service'] == 'kcp') { ?>
        f.site_cd.value = f.def_site_cd.value;
        if(typeof f.payco_direct !== "undefined") f.payco_direct.value = "";
        if(typeof f.naverpay_direct !== "undefined") f.naverpay_direct.value = "A";
        if(typeof f.kakaopay_direct !== "undefined") f.kakaopay_direct.value = "A";
        switch(settle_method)
        {
            case "계좌이체":
                f.pay_method.value   = "010000000000";
                break;
            case "가상계좌":
                f.pay_method.value   = "001000000000";
                break;
            case "휴대폰":
                f.pay_method.value   = "000010000000";
                break;
            case "신용카드":
                f.pay_method.value   = "100000000000";
                break;
            case "간편결제":
                f.pay_method.value   = "100000000000";
                
                var nhnkcp_easy_pay = jQuery("input[name='od_settle_case']:checked" ).attr("data-pay");
                
                if(nhnkcp_easy_pay === "naverpay"){
                    if(typeof f.naverpay_direct !== "undefined") f.naverpay_direct.value = "Y";
                } else if(nhnkcp_easy_pay === "kakaopay"){
                    if(typeof f.kakaopay_direct !== "undefined") f.kakaopay_direct.value = "Y";
                } else {
                    if(typeof f.payco_direct !== "undefined") f.payco_direct.value = "Y";
                    <?php if($default['de_card_test']) { ?>
                    f.site_cd.value      = "S6729";
                    <?php } ?>
                }

                break;
            default:
                f.pay_method.value   = "무통장";
                break;
        }
        <?php } else if($default['de_pg_service'] == 'lg') { ?>
        f.LGD_EASYPAY_ONLY.value = "";
        if(typeof f.LGD_CUSTOM_USABLEPAY === "undefined") {
            var input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", "LGD_CUSTOM_USABLEPAY");
            input.setAttribute("value", "");
            f.LGD_EASYPAY_ONLY.parentNode.insertBefore(input, f.LGD_EASYPAY_ONLY);
        }

        switch(settle_method)
        {
            case "계좌이체":
                f.LGD_CUSTOM_FIRSTPAY.value = "SC0030";
                f.LGD_CUSTOM_USABLEPAY.value = "SC0030";
                break;
            case "가상계좌":
                f.LGD_CUSTOM_FIRSTPAY.value = "SC0040";
                f.LGD_CUSTOM_USABLEPAY.value = "SC0040";
                break;
            case "휴대폰":
                f.LGD_CUSTOM_FIRSTPAY.value = "SC0060";
                f.LGD_CUSTOM_USABLEPAY.value = "SC0060";
                break;
            case "신용카드":
                f.LGD_CUSTOM_FIRSTPAY.value = "SC0010";
                f.LGD_CUSTOM_USABLEPAY.value = "SC0010";
                break;
            case "간편결제":
                var elm = f.LGD_CUSTOM_USABLEPAY;
                if(elm.parentNode)
                    elm.parentNode.removeChild(elm);
                f.LGD_EASYPAY_ONLY.value = "PAYNOW";
                break;
            default:
                f.LGD_CUSTOM_FIRSTPAY.value = "무통장";
                break;
        }
        <?php }  else if($default['de_pg_service'] == 'inicis') { ?>
        switch(settle_method)
        {
            case "계좌이체":
                f.gopaymethod.value = "DirectBank";
                break;
            case "가상계좌":
                f.gopaymethod.value = "VBank";
                break;
            case "휴대폰":
                f.gopaymethod.value = "HPP";
                break;
            case "신용카드":
                f.gopaymethod.value = "Card";
                f.acceptmethod.value = f.acceptmethod.value.replace(":useescrow", "");
                break;
            case "간편결제":
                f.gopaymethod.value = "Kpay";
                break;
            case "lpay":
                f.gopaymethod.value = "onlylpay";
                f.acceptmethod.value = f.acceptmethod.value+":cardonly";
                break;
            case "inicis_kakaopay":
                f.gopaymethod.value = "onlykakaopay";
                f.acceptmethod.value = f.acceptmethod.value+":cardonly";
                break;
            default:
                f.gopaymethod.value = "무통장";
                break;
        }
        <?php } ?>

        // 결제정보설정
        <?php if($default['de_pg_service'] == 'kcp') { ?>
        f.buyr_name.value = f.od_name.value;
        f.buyr_mail.value = f.od_email.value;
        f.buyr_tel1.value = f.od_tel.value;
        f.buyr_tel2.value = f.od_hp.value;
        f.rcvr_name.value = f.od_b_name.value;
        f.rcvr_tel1.value = f.od_b_tel.value;
        f.rcvr_tel2.value = f.od_b_hp.value;
        f.rcvr_mail.value = f.od_email.value;
        f.rcvr_zipx.value = f.od_b_zip.value;
        f.rcvr_add1.value = f.od_b_addr1.value;
        f.rcvr_add2.value = f.od_b_addr2.value;

        if(f.pay_method.value != "무통장") {
            jsf__pay( f );
        } else {
            f.submit();
        }
        <?php } ?>
        <?php if($default['de_pg_service'] == 'lg') { ?>
        f.LGD_BUYER.value = f.od_name.value;
        f.LGD_BUYEREMAIL.value = f.od_email.value;
        f.LGD_BUYERPHONE.value = f.od_hp.value;
        f.LGD_AMOUNT.value = f.good_mny.value;
        f.LGD_RECEIVER.value = f.od_b_name.value;
        f.LGD_RECEIVERPHONE.value = f.od_b_hp.value;
        <?php if($default['de_escrow_use']) { ?>
        f.LGD_ESCROW_ZIPCODE.value = f.od_b_zip.value;
        f.LGD_ESCROW_ADDRESS1.value = f.od_b_addr1.value;
        f.LGD_ESCROW_ADDRESS2.value = f.od_b_addr2.value;
        f.LGD_ESCROW_BUYERPHONE.value = f.od_hp.value;
        <?php } ?>
        <?php if($default['de_tax_flag_use']) { ?>
        f.LGD_TAXFREEAMOUNT.value = f.comm_free_mny.value;
        <?php } ?>

        if(f.LGD_CUSTOM_FIRSTPAY.value != "무통장") {
            launchCrossPlatform(f);
        } else {
            f.submit();
        }
        <?php } ?>
        <?php if($default['de_pg_service'] == 'inicis') { ?>
//        f.price.value       = f.good_mny.value;
        f.price.value       = tot_price;
        <?php if($default['de_tax_flag_use']) { ?>
        f.tax.value         = f.comm_vat_mny.value;
        f.taxfree.value     = f.comm_free_mny.value;
        <?php } ?>
        f.buyername.value   = f.od_name.value;
        f.buyeremail.value  = f.od_email.value;
        f.buyertel.value    = f.od_b_hp.value ? f.od_b_hp.value : f.od_b_tel.value;
        f.recvname.value    = f.od_b_name.value;
        f.recvtel.value     = f.od_b_hp.value ? f.od_b_hp.value : f.od_b_tel.value;
        f.recvpostnum.value = f.od_b_zip.value;
        f.recvaddr.value    = f.od_b_addr1.value + " " +f.od_b_addr2.value;

        if(f.gopaymethod.value != "무통장") {
            // 주문정보 임시저장
            var order_data = $(f).serialize();
            var save_result = "";
            $.ajax({
                type: "POST",
                data: order_data,
                url: g5_url+"/shop/ajax.orderdatasave.php",
                cache: false,
                async: false,
                success: function(data) {
                    save_result = data;
                }
            });

            if(save_result) {
                alert(save_result);
                return false;
            }

            if(!make_signature(f))
                return false;
            
            paybtn(f);
        } else {
            f.submit();
        }
        <?php } ?>
    }

}

// 구매자 정보와 동일합니다.
function gumae2baesong() {
    var f = document.forderform;

    f.od_b_name.value = f.od_name.value;
    f.od_b_tel.value  = f.od_tel.value;
    f.od_b_hp.value   = f.od_hp.value;
    f.od_b_zip.value  = f.od_zip.value;
    f.od_b_addr1.value = f.od_addr1.value;
    f.od_b_addr2.value = f.od_addr2.value;
    f.od_b_addr3.value = f.od_addr3.value;
    f.od_b_addr_jibeon.value = f.od_addr_jibeon.value;

    calculate_sendcost(String(f.od_b_zip.value));
}

<?php if ($default['de_hope_date_use']) { ?>
$(function(){
    $("#od_hope_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", minDate: "+<?php echo (int)$default['de_hope_date_after']; ?>d;", maxDate: "+<?php echo (int)$default['de_hope_date_after'] + 6; ?>d;" });
});
<?php } ?>
</script>
