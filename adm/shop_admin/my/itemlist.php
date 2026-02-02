<?php
if (!defined('_GNUBOARD_')) exit;
?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
    <span class="btn_ov01"><span class="ov_txt">등록된 상품</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
	
	<a href="<?=G5_ADMIN_URL?>/shop_admin/my/_excel_itemlist.php" class="btn_excel_download" target="_blank">엑셀 다운로드</a>

</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

<label for="sca" class="sound_only">분류선택</label>
<select name="sca" id="sca">
    <option value="">전체분류</option>
    <?php
    $sql1 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
    $result1 = sql_query($sql1);
    for ($i=0; $row1=sql_fetch_array($result1); $i++) {
        $len = strlen($row1['ca_id']) / 2 - 1;
        $nbsp = '';
        for ($i=0; $i<$len; $i++) $nbsp .= '&nbsp;&nbsp;&nbsp;';
        echo '<option value="'.$row1['ca_id'].'" '.get_selected($sca, $row1['ca_id']).'>'.$nbsp.$row1['ca_name'].'</option>'.PHP_EOL;
    }
    ?>
</select>

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="it_name" <?php echo get_selected($sfl, 'it_name'); ?>>상품명</option>
    <option value="it_id" <?php echo get_selected($sfl, 'it_id'); ?>>상품코드</option>
    <option value="it_maker" <?php echo get_selected($sfl, 'it_maker'); ?>>제조사</option>
    <option value="it_origin" <?php echo get_selected($sfl, 'it_origin'); ?>>원산지</option>
    <option value="it_sell_email" <?php echo get_selected($sfl, 'it_sell_email'); ?>>판매자 e-mail</option>
</select>

<label for="stx" class="sound_only">검색어</label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>

<form name="fitemlistupdate" method="post" action="./itemlistupdate.php" onsubmit="return fitemlist_submit(this);" autocomplete="off" id="fitemlistupdate">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" rowspan="3">
            <label for="chkall" class="sound_only">상품 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col" rowspan="3"><?php echo subject_sort_link('it_id', 'sca='.$sca); ?>상품코드</a></th>
        <th scope="col" colspan="5">분류</th>
        <th scope="col" rowspan="3"><?php echo subject_sort_link('it_order', 'sca='.$sca); ?>순서</a></th>
        <th scope="col" rowspan="3"><?php echo subject_sort_link('it_use', 'sca='.$sca, 1); ?>판매</a></th>
        <th scope="col" rowspan="3"><?php echo subject_sort_link('it_soldout', 'sca='.$sca, 1); ?>품절</a></th>
        <th scope="col" rowspan="3"><?php echo subject_sort_link('it_hit', 'sca='.$sca, 1); ?>조회</a></th>
        <th scope="col" rowspan="3">관리</th>
    </tr>
    <tr>
        <th scope="col" rowspan="2" id="th_img" class="w-85">이미지</th>
        <th scope="col" rowspan="2" id="th_pc_title"><?php echo subject_sort_link('it_name', 'sca='.$sca); ?>상품명</a></th>
        <th scope="col" id="th_amt"><?php echo subject_sort_link('it_price', 'sca='.$sca); ?>판매가격</a></th>
        <th scope="col" id="th_camt"><?php echo subject_sort_link('it_cust_price', 'sca='.$sca); ?>시중가격</a></th>
        <th scope="col" id="th_skin">PC스킨</th>
    </tr>
    <tr>
        <th scope="col" id="th_pt"><?php echo subject_sort_link('it_point', 'sca='.$sca); ?>포인트</a></th>
        <th scope="col" id="th_qty"><?php echo subject_sort_link('it_stock_qty', 'sca='.$sca); ?>출고지</a></th>
        <th scope="col" id="th_mskin">모바일스킨</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)    {
        $href = shop_item_url($row['it_id']);
        $bg = 'bg'.($i%2);

        $it_point = $row['it_point'];
        if($row['it_point_type'])
            $it_point .= '%';
    ?>
    <tr class="<?php echo $bg; ?>">
        <td rowspan="3" class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
        </td>
        <td rowspan="3" class="td_num">
            <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
            <?php echo $row['it_id']; ?>
        </td>
        <td colspan="2" class="td_sort tleft">
			<div class="flex flex-middle gap30">
				<div class="inline-flex flex-middle gap10">
					<label for="ca_id_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?> 기본분류</label>
					<select name="ca_id[<?php echo $i; ?>]" id="ca_id_<?php echo $i; ?>">
						<?php echo conv_selected_option($ca_list, $row['ca_id']); ?>
					</select>
					<label for="ca_id2_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?> 2차분류</label>
					<select name="ca_id2[<?php echo $i; ?>]" id="ca_id2_<?php echo $i; ?>">
						<?php echo conv_selected_option($ca_list, $row['ca_id2']); ?>
					</select>
					<label for="ca_id3_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?> 3차분류</label>
					<select name="ca_id3[<?php echo $i; ?>]" id="ca_id3_<?php echo $i; ?>">
						<?php echo conv_selected_option($ca_list, $row['ca_id3']); ?>
					</select>
				</div>
				<?php
				$itemtype = explode("|", $default['itemtype']);
				echo '<div class="inline-flex flex-middle gap20 fs11 fw400">';
				for ($t=0; $t < count($itemtype); $t++) {
					$num[$i] = $t + 1;
					if($itemtype[$t]) echo '<input type="checkbox" name="it_type'.$num[$i].'['.$i.']" value="1" '.($row['it_type'.$num[$i]] ? "checked" : "").' id="it_type1" data-class="small" data-label="'.$itemtype[$t].'">';
				}
				echo '</div>';
				?>
			</div>
        </td>
		<!--
		<td colspan="3" class="td_num">
            판매 시작일 <input type="date" name="it_sale_start_date[<?php echo $i; ?>]" value="<?php echo $row['it_sale_start_date']; ?>">
			<br>
            판매 종료일 <input type="date" name="it_sale_end_date[<?php echo $i; ?>]" value="<?php echo $row['it_sale_end_date']; ?>">
        </td>
		-->
		<td colspan="3" class="td_num">
			판매 시작일 <input type="text" class="form-control" name="it_sale_start_date[<?php echo $i; ?>]" 
						   id="datetimepicker1_<?=$i?>" Placeholder="판매 시작일" 
						   value="<?php echo $row['it_sale_start_date']; ?>">
			<button type="button" class="btn btn-danger clearDate" data-target="datetimepicker1_<?=$i?>" 
					style="margin-left:0px;">삭제</button>
			<br>
			판매 종료일 <input type="text" class="form-control" name="it_sale_end_date[<?php echo $i; ?>]" 
						   id="datetimepicker2_<?=$i?>" Placeholder="판매 종료일" 
						   value="<?php echo $row['it_sale_end_date']; ?>">
			<button type="button" class="btn btn-danger clearDate" data-target="datetimepicker2_<?=$i?>" 
					style="margin-left:0px;">삭제</button>
		</td>

		
        <td rowspan="3" class="td_num">
            <label for="order_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_order[<?php echo $i; ?>]" value="<?php echo $row['it_order']; ?>" id="order_<?php echo $i; ?>" class="tbl_input" size="3">
        </td>
        <td rowspan="3">
            <label for="use_<?php echo $i; ?>" class="sound_only">판매여부</label>
            <input type="checkbox" name="it_use[<?php echo $i; ?>]" <?php echo ($row['it_use'] ? 'checked' : ''); ?> value="1" id="use_<?php echo $i; ?>">
        </td>
        <td rowspan="3">
            <label for="soldout_<?php echo $i; ?>" class="sound_only">품절</label>
            <input type="checkbox" name="it_soldout[<?php echo $i; ?>]" <?php echo ($row['it_soldout'] ? 'checked' : ''); ?> value="1" id="soldout_<?php echo $i; ?>">
        </td>
        <td rowspan="3" class="td_num"><?php echo $row['it_hit']; ?></td>
        <td rowspan="3" class="td_mng td_mng_s">
            <a href="./itemform.php?w=u&amp;it_id=<?php echo $row['it_id']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>&amp;<?php echo $qstr; ?>" class="btn btn_03" target="_blink" rel="noreferrer noopener"><span class="sound_only"><?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?> </span>수정</a>
            <a href="./itemcopy.php?it_id=<?php echo $row['it_id']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>" class="itemcopy btn btn_02" target="_blank"><span class="sound_only"><?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?> </span>복사</a>
            <a href="<?php echo $href; ?>" class="btn btn_02"><span class="sound_only"><?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?> </span>보기</a>
        </td>
    </tr>
    <tr class="<?php echo $bg; ?>">
        <td rowspan="2" class="td_img"><a href="<?php echo $href; ?>"><?php echo get_it_image($row['it_id'], 70, 70); ?></a></td>
        <td headers="th_pc_title" rowspan="2" class="td_input tleft">
			<?php
			$it_timer_arr[$i] = explode('|', $row['it_timer']);
			if($it_timer_arr[$i][0]) echo get_buy_timer($row['it_id']);
			?>
            <label for="name_<?php echo $i; ?>" class="sound_only">상품명</label>
            <input type="text" name="it_name[<?php echo $i; ?>]" value="<?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?>" id="name_<?php echo $i; ?>" required class="tbl_input required fs14 inputColor-gray3 price" size="30">
        </td>
        <td headers="th_amt" class="td_numbig td_input">
            <label for="price_<?php echo $i; ?>" class="sound_only">판매가격</label>
            <input type="text" name="it_price[<?php echo $i; ?>]" value="<?php echo $row['it_price']; ?>" id="price_<?php echo $i; ?>" class="tbl_input sit_amt color-red" size="7">
        </td>
        <td headers="th_camt" class="td_numbig td_input">
            <label for="cust_price_<?php echo $i; ?>" class="sound_only">시중가격</label>
            <input type="text" name="it_cust_price[<?php echo $i; ?>]" value="<?php echo $row['it_cust_price']; ?>" id="cust_price_<?php echo $i; ?>" class="tbl_input sit_camt" size="7">
        </td>
        <td headers="th_skin" class="td_numbig td_input">
            <label for="it_skin_<?php echo $i; ?>" class="sound_only">PC 스킨</label>
            <?php echo get_skin_select('shop', 'it_skin_'.$i, 'it_skin['.$i.']', $row['it_skin']); ?>
        </td>
    </tr>
    <tr class="<?php echo $bg; ?>">
        <td headers="th_pt" class="td_numbig td_input"><?php echo $it_point; ?></td>
        <td headers="th_qty" class="td_numbig td_input">
		<!--
            <label for="stock_qty_<?php echo $i; ?>" class="sound_only">재고</label>
		-->
			<?php
			echo '<div class="flex flex-middle gap20">';
				echo '<select name="it_shpping_name['.$i.']" id="it_shpping_name" class="selectpicker">';
					$shop_sql = "select * from `g5_shop_shipping` order by sh_name asc";
					$shop_result = sql_query($shop_sql);
					echo option_selected_my('',  $row['it_shpping_name'], "", "data-content='출고지 선택'");
					for ($u=0; $ros=sql_fetch_array($shop_result); $u++) {
						echo option_selected_my($ros['sh_id'],  $row['it_shpping_name'], $ros['sh_name'], "data-content='".$ros['sh_name']."'");
					}
				echo '</select>'.PHP_EOL;
			echo '</div>';
			//if($is_admin) echo '<a href="'.G5_ADMIN_URL.'/shop_admin/my/storelist.php" class="_btn/mainColor rd5 ml10" target="_blank">'.$store_label.' 관리</a>';
			?>
            <input type="hidden" name="it_stock_qty[<?php echo $i; ?>]" value="<?php echo $row['it_stock_qty']; ?>" id="stock_qty_<?php echo $i; ?>" class="tbl_input sit_qty" size="7">
        </td>
        <td headers="th_mskin" class="td_numbig td_input">
            <label for="it_mobile_skin_<?php echo $i; ?>" class="sound_only">모바일 스킨</label>
            <?php echo get_mobile_skin_select('shop', 'it_mobile_skin_'.$i, 'it_mobile_skin['.$i.']', $row['it_mobile_skin']); ?>
        </td>
    </tr>
    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="12" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">

    <a href="./itemform.php" class="btn btn_01">상품등록</a>
    <a href="./itemexcel.php" onclick="return excelform(this.href);" target="_blank" class="btn btn_02">상품일괄등록</a>
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_02">
    <?php if ($is_admin == 'super') { ?>
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
    <?php } ?>
</div>
<!-- <div class="btn_confirm01 btn_confirm">
    <input type="submit" value="일괄수정" class="btn_submit" accesskey="s">
</div> -->
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- 헤더에 이 파일들이 있는지 확인 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>


<style>
.bootstrap-datetimepicker-widget {
    width: 250px !important;
    position: fixed !important;
    z-index: 9999 !important;
    background-color: white !important;  /* 배경색 흰색으로 설정 */
    border: 1px solid #ddd !important;   /* 테두리 추가 */
    box-shadow: 0 2px 4px rgba(0,0,0,0.2) !important;  /* 그림자 효과 추가 */
}

td .form-control {
    width: 150px !important;
    display: inline-block !important;
}

.bootstrap-datetimepicker-widget .fa {
   line-height: 1;
   vertical-align: middle;
}


</style>

<script>
$(function() {
    $('[id^="datetimepicker1_"]').each(function() {
        $(this).datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            stepping: 30,
            locale: 'ko',
            sideBySide: true,
            icons: {
                up: 'fa fa-angle-up',    // 위쪽 화살표
                down: 'fa fa-angle-down', // 아래쪽 화살표
                previous: 'fa fa-angle-left',  // 이전
                next: 'fa fa-angle-right',     // 다음
                time: 'fa fa-clock',           // 시계
                date: 'fa fa-calendar',        // 달력
                today: 'fa fa-calendar-check', // 오늘
                clear: 'fa fa-trash',          // 삭제
                close: 'fa fa-times'           // 닫기
            }
        });
    });

    // 종료일에도 동일하게 적용
    $('[id^="datetimepicker2_"]').each(function() {
        $(this).datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            stepping: 30,
            locale: 'ko',
            sideBySide: true,
            icons: {
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down',
                previous: 'fa fa-angle-left',
                next: 'fa fa-angle-right',
                time: 'fa fa-clock',
                date: 'fa fa-calendar',
                today: 'fa fa-calendar-check',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        });
    });
	
	// 삭제 버튼 클릭 이벤트
    $('.clearDate').click(function() {
        var targetId = $(this).data('target');
        $('#' + targetId).val('');
    });
});
</script>
			
			
<script>
function fitemlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

$(function() {
    $(".itemcopy").click(function() {
        var href = $(this).attr("href");
        window.open(href, "copywin", "left=100, top=100, width=300, height=200, scrollbars=0");
        return false;
    });
});

function excelform(url)
{
    var opt = "width=600,height=450,left=10,top=10";
    window.open(url, "win_excel", opt);
    return false;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');