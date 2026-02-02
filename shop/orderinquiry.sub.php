<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined("_ORDERINQUIRY_")) exit; // 개별 페이지 접근 불가

//인태
if(file_exists(G5_THIS_SHOP_PATH.'/orderinquiry.sub.php')) {
	require_once(G5_THIS_SHOP_PATH.'/orderinquiry.sub.php');
	return;
}
if(file_exists(G5_THEME_SHOP_PATH.'/orderinquiry.sub.php')) {
	require_once(G5_THEME_SHOP_PATH.'/orderinquiry.sub.php');
	return;
}
?>

<!-- 주문 내역 목록 시작 { -->
<?php if (!$limit) { ?>총 <?php echo $cnt; ?> 건<?php } ?>

<div class="tbl_head03 tbl_wrap">
    <table>
    <thead>
    <tr>
        <th scope="col">주문서번호</th>
        <th scope="col">주문일시</th>
        <th scope="col">상품수</th>
        <th scope="col">주문금액</th>
        <th scope="col">입금액</th>
        <th scope="col">미입금액</th>
        <th scope="col">상태</th>
    </tr>
    </thead>
    <tbody>
    <?php
	
	//if($_SERVER["REMOTE_ADDR"] == "121.161.30.109"){
		
		if(!$search){

			$sql = " select *
					   from {$g5['g5_shop_order_table']}
					  where mb_id = '{$member['mb_id']}'
					  order by od_id desc
					  $limit ";
		}else{

			$sql = " select *
					   from {$g5['g5_shop_order_table']} a, {$g5['g5_shop_cart_table']} b
					  where a.mb_id = '{$member['mb_id']}' and
							b.mb_id = '{$member['mb_id']}' and
							b.ct_status != '쇼핑' and
							b.it_name like '%$search%'
					  order by a.od_id desc
					  $limit ";
		
		}

	//}else{
		/*
		$sql = " select *
				   from {$g5['g5_shop_order_table']}
				  where mb_id = '{$member['mb_id']}'
				  order by od_id desc
				  $limit ";
				  */
	//}

	$result = sql_query($sql);
	
	if($_SERVER["REMOTE_ADDR"] == "121.161.30.109"){
		//echo $sql;
	}
	
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);
		
		$bg = 'bg'.($i%2);
        switch($row['od_status']) {
            case '주문':
                $od_status = '<span class="status_01">입금확인중</span>';
                break;
            case '입금':
                $od_status = '<span class="status_02">입금완료</span>';
                break;
            case '준비':
                $od_status = '<span class="status_03">상품준비중</span>';
                break;
            case '배송':
                $od_status = '<span class="status_04">상품배송</span>';
                break;
            case '완료':
                $od_status = '<span class="status_05">배송완료</span>';
                break;
            default:
                $od_status = '<span class="status_06">주문취소</span>';
                break;
        }

    ?>
<?if($search){?>
	<tr <?if($bg=="bg0"){?>style="background: rgb(0 0 0 / 3.5%);"<?}?>>
		<td colspan="2" style="padding:10px 15px !important"><?php echo $row['it_name']?></td>
		<td rowspan="2" class="td_numbig tcenter"><?php echo $row['od_cart_count']; ?></td>
        <td rowspan="2" class="td_numbig tright"><?php echo display_price($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></td>
        <td rowspan="2" class="td_numbig tright"><?php echo display_price($row['od_receipt_price']); ?></td>
        <td rowspan="2" class="td_numbig tright"><?php echo display_price($row['od_misu']); ?></td>
        <td rowspan="2" class="tcenter"><?php echo $od_status; ?></td>
	</tr>
	<tr <?if($bg=="bg0"){?>style="background: rgb(0 0 0 / 4%);"<?}?>>
        <td>
            <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>"><?php echo $row['od_id']; ?></a>
        </td>
        <td><?php echo substr($row['od_time'],2,14); ?> (<?php echo get_yoil($row['od_time']); ?>)</td>
        
    </tr>
<?}else{?>
    <tr>
        <td>
            <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>"><?php echo $row['od_id']; ?></a>
        </td>
        <td><?php echo substr($row['od_time'],2,14); ?> (<?php echo get_yoil($row['od_time']); ?>)</td>
        <td class="td_numbig tcenter"><?php echo $row['od_cart_count']; ?></td>
        <td class="td_numbig tright"><?php echo display_price($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></td>
        <td class="td_numbig tright"><?php echo display_price($row['od_receipt_price']); ?></td>
        <td class="td_numbig tright"><?php echo display_price($row['od_misu']); ?></td>
        <td class="tcenter"><?php echo $od_status; ?></td>
    </tr>
<?}?>	

    <?php
    }

    if ($i == 0)
        echo '<tr><td colspan="7" class="empty_table tcenter">주문 내역이 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>
<!-- } 주문 내역 목록 끝 -->