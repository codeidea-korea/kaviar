<?php
$sub_menu = '400904';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = '출고지 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$where = array();


$where[] = " sh_delyn = 'N' ";


$sql_where = $where ? " where " . implode(" and ", $where) : '';

$sql_common = " from `g5_shop_shipping` ";
$sql_common .= $sql_where;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 40;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$shop_sql = "select * $sql_common  limit $from_record, {$rows} ";
$shop_result = sql_query($shop_sql);

$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$write_pages = get_paging($rows, $page, $total_page, shop_short_url_my('shopStore','',$qstr.'&amp;page='));

$store_id = isset($_REQUEST['store_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['store_id']) : 0;

?>


<section class="mybox p15" id="anc_scf_store">
    <div class="tbl_frm01 noline">
        <table>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>				
				<tr>
					<th scope="row"><label>출고지 등록</label></th>
					<td>
						<form name="fconfig2" action="./shippinglocation_update.php" method="post">
						<input type="hidden" name="type"  value="insert">
						<input type="text" name="sh_name"  id="store_label_name" class="frm_input">
						<input type="submit" value="등록하기" class="btn_submit btn" accesskey="s">
						</form>
					</td>
				</tr>
			</tbody>
        </table>
    </div>	
</section>



<div class="local_ov01 local_ov mt25">
    <?php echo $listall; ?>
    <span class="btn_ov01"><span class="ov_txt">등록된 출고지</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
</div>

<section class="mybox blue p15" style="width:430px">
	<div class="tbl_head01 tbl_wrap">
		<table>
			<colgroup>
				<col width="50">
				<col width="250">
				<col width="140">
			</colgroup>
			<thead>
				<tr>
					<th>NO</th>
					<th>출고지명</th>
					<th id="th_mng">관리</th>
				</tr>
			</thead>
			<tbody>
				<?php
				for ($i=0; $row=sql_fetch_array($shop_result); $i++) {
					$store_address[$i] = explode('|', $row['store_address']);
					echo '<tr>';
						echo '<td>';
							echo '<label for="chk_'.$i.'" class="sound_only">'.get_text($row['it_name']).'</label>';
							echo '<input type="checkbox" name="chk[]" value="'.$i.'" id="chk_'.$i.'">';
						echo '</td>';
					
						echo '<td>'.$row['sh_name'].'</td>';
						
						echo '<td class="td_mng td_mns_m">';
							echo '<a href="./shippinglocation_update.php?type=delete&ids='.$row['sh_id'].'" onclick="return delete_confirm(this);" class="btn btn_02">삭제</a>';
						echo '</td>';
					echo '</tr>';
				}
				if($i==0) echo '<tr><td colspan="8" class="empty_table">등록된 출고지가 없습니다.</td></tr>';
				?>
			</tbody>
		</table>
	</div>

	<?=$write_pages?>

</section>




<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');