<?php
$sub_menu = '400902';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = $store_label.'관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$where = array();

if (!$is_admin){
	$where[] = " store_use = '1' ";
}

$q = utf8_strcut(get_search_string(trim($_GET['q'])), 30, "");

if ($q) {
    $arr = explode(" ", $q);
    $detail_where = array();

	 for ($i=0; $i<count($arr); $i++) {
        $word = trim($arr[$i]);
        if (!$word) continue;

        $detail_where[] = " store_address like '%$word%' ";
    }

    $where[] = "(".implode(" and ", $detail_where).")";

}

$sql_where = $where ? " where " . implode(" and ", $where) : '';

$sql_common = " from {$g5['g5_shop_store_table']} ";
$sql_common .= $sql_where;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 40;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$shop_sql = "select * $sql_common order by store_order < 0, store_order = 0, store_order, store_id limit $from_record, {$rows} ";
$shop_result = sql_query($shop_sql);

$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

//$write_pages = get_paging($rows, $page, $total_page, shop_short_url_my('shopStore','',$qstr.'&amp;page='));
$write_pages = get_paging($rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page=');

$store_id = isset($_REQUEST['store_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['store_id']) : 0;
if($store_id) {
	$sql = " select * from {$g5['g5_shop_store_table']} where store_id = '$store_id' ";
	$store = sql_fetch($sql);
}
?>


<section class="mybox p15" id="anc_scf_store">
    <div class="tbl_frm01 noline">
        <table>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>				
				<?php if(!sql_query(" DESCRIBE {$g5['g5_shop_store_table']} ", false)) {
					echo '<tr>';
						echo '<th scope="row"><label>'.$store_label.' 검색 페이지 사용</label></th>';
						echo '<td>';
							echo '<div class="flex flex-middle gap20">';
								echo '<p>'.$store_label.' 등록 테이블이 생성되지 않았습니다.<br>'.$store_label.' 검색 페이지를 사용하려면 테이블을 생성하세요.</p>';
								echo '<a href="'.G5_ADMIN_URL.'/shop_admin/my/_add_shop_store_table.php" class="btn_frmline ml10">테이블 생성</a>';
							echo '</div>';
						echo '</td>';
					echo '</tr>';
				} ?>					
				<tr>
					<th scope="row"><label>카카오 API</label></th>
					<td>
						<form name="fconfig" action="./kakaoapiupdate.php" method="post">
						<p>
							<label class="labelInput"><b class="label">JavaScript 키</b><input type="text" name="cf_kakao_app_key" value="<?=get_text($config['cf_kakao_app_key'])?>" id="cf_kakao_app_key" class="frm_input span350" size="50" maxlength="60"></label>
							<a href="https://developers.kakao.com/" target="_blank" class="btn ml10" style="height:26px;line-height:1em;background:#ffcc00;display:inline-flex;align-items:center;justify-content:center;color:#645d40">카카오 API 신청</a>
						</p>
						<p class="help-block mt5">* <?=$store_label?> 좌표를 사용하기 위해 카카오 API를 신청하고 javascript 키를 발급받아야 합니다.</p>
						<div class="btnSet">
							<input type="submit" value="확인" class="btn_submit btn" accesskey="s">
						</div>
						</form>
					</td>
				</tr>
				<tr>
					<th scope="row"><label>[<?=$store_label?>] 라벨명</label></th>
					<td>
						<form name="fconfig2" action="./storelabelupdate.php" method="post">
						<input type="text" name="store_label_name" value="<?php echo get_sanitize_input($default['store_label_name']); ?>" id="store_label_name" class="frm_input" placeholder="<?=$store_label?>">
						<input type="submit" value="확인" class="btn_submit btn" accesskey="s">
						</form>
					</td>
				</tr>
			</tbody>
        </table>
    </div>	
</section>



<div class="local_ov01 local_ov mt25">
    <?php echo $listall; ?>
    <span class="btn_ov01"><span class="ov_txt">등록된 <?=$store_label?></span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
</div>

<section class="mybox blue p15">
	<div class="tbl_head01 tbl_wrap">
		<table>
			<colgroup>
				<!--<col width="70">-->
				<!--<col width="70">-->
				<col width="150">
				<col width="120">
				<col width="200">
				<col>
				<col width="120">
				<col width="120">
				<col width="120">
				<col width="120">
			</colgroup>
			<thead>
				<tr>
					<!--<th>
						<label for="chkall" class="sound_only">전체선택</label>
						<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
					</th>-->
					<!--<th>출력순서</th>-->
					<th>ID</th>
					<th>사용여부</th>						
					<th><?=$default['store_label_name']?$default['store_label_name']:'지점'?>명</th>
					<th><?=$store_label?> 주소</th>	
					<th>상품수</th>
					<th>상품 출력 (가로수)</th>
					<th>상품 출력 (줄수)</th>
					<th>바로가기</th>
					<th id="th_mng">관리</th>
				</tr>
			</thead>
			<tbody>
				<?php
				for ($i=0; $row=sql_fetch_array($shop_result); $i++) {
					$store_address[$i] = explode('|', $row['store_address']);
					echo '<tr>';
						/*echo '<td>';
							echo '<label for="chk_'.$i.'" class="sound_only">'.get_text($row['it_name']).'</label>';
							echo '<input type="checkbox" name="chk[]" value="'.$i.'" id="chk_'.$i.'">';
						echo '</td>';*/
						//echo '<td>'.$row['store_order'].'</td>';
						echo '<td>'.$row['store_id'].'</td>';
						echo '<td>'.($row['store_use']?'사용':'사용안함').'</td>';						
						echo '<td class="bold">'.$row['store_subject'].'</td>';
						echo '<td class="tleft">'.$store_address[$i][0].$store_address[$i][1].'</td>';
						echo '<td>'.get_store_items_count($row['store_id']).'</td>';
						echo '<td>'.($row['store_wr1']?$row['store_wr1']:'3').'</td>';
						echo '<td>'.($row['store_wr2']?$row['store_wr2']:'5').'</td>';
						echo '<td><a href="'.shop_short_url_my('shopStore','','store_id='.$row['store_id']).'" target="_blank" class="btn_frmline">'.$store_label.' 바로가기</a></td>';
						echo '<td class="td_mng td_mns_m">';
							echo '<a href="./storeform.php?w=u&amp;store_id='.$row['store_id'].'" class="btn btn_03" rel="noreferrer noopener">수정</a>';
							echo '<a href="./storeformupdate.php?w=d&amp;store_id='.$row['store_id'].'" onclick="return delete_confirm(this);" class="btn btn_02">삭제</a>';
						echo '</td>';
					echo '</tr>';
				}
				if($i==0) echo '<tr><td colspan="8" class="empty_table">등록된 '.$store_label.'이 없습니다.</td></tr>';
				?>
			</tbody>
		</table>
	</div>

	<div class="btn_fixed_top">
		<a href="./storeform.php" class="btn btn_01"><?=$store_label?>등록</a>
	</div>

	<?=$write_pages?>

</section>




<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');