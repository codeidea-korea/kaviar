<?php
$sub_menu = '400903';
include_once('./_common.php');

$g5['membercode_table'] = G5_TABLE_PREFIX.'membercode';

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = '기업코드 관리';
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

$sql_common = " from {$g5['membercode_table']} ";
//$sql_common .= $sql_where;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 40;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$code_sql = "select * $sql_common order by code_num limit $from_record, {$rows} ";
$code_result = sql_query($code_sql);

$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$write_pages = get_paging($rows, $page, $total_page, shop_short_url_my('shopStore','',$qstr.'&amp;page='));

$code_num = isset($_REQUEST['code_num']) ? preg_replace('/[^0-9]/', '', $_REQUEST['code_num']) : 0;
if($code_num) {
	$sql = " select * from {$g5['membercode_table']} where code_num = '$code_num' ";
	$code = sql_fetch($sql);
}


?>


<?php if(!sql_query(" DESCRIBE {$g5['membercode_table']} ", false)) { ?>

<section class="mybox p15">
    <div class="tbl_frm01 noline">
        <table>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>			
				<tr>
					<th scope="row"><label>기업 코드 사용</label></th>
					<td>
						<div class="flex flex-middle gap20">
							<p>기업코드 테이블이 생성되지 않았습니다.<br>기업코드를 사용하려면 테이블을 생성하세요.</p>
							<a href="<?=G5_ADMIN_URL?>/shop_admin/my/_add_membercode_table.php" class="btn_frmline ml10">테이블 생성</a>
						</div>
					</td>
				</tr>
			</tbody>
        </table>
    </div>	
</section>

<?php } else { ?>

<div class="local_ov01 local_ov mt25">
    <?php echo $listall; ?>
    <span class="btn_ov01"><span class="ov_txt">등록된 기업코드</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
</div>

<section class="mybox blue p15">
	<div class="tbl_head01 tbl_wrap">
		<table>
			<colgroup>				
				<col width="120">
				<col width="150">
				<col>
				<col>
				<col width="120">
			</colgroup>
			<thead>
				<tr>
					<th>번호</th>
					<th>사용여부</th>
					<th>코드명</th>
					<th>기업명</th>
					<th id="th_mng">관리</th>
				</tr>
			</thead>
			<tbody>
				<?php
				for ($i=0; $row=sql_fetch_array($code_result); $i++) {
					echo '<tr'.(!$row['code_use']?' style="background:rgba(0,0,0,0.02);"':'').'>';
						echo '<td>'.$row['code_num'].'</td>';
						echo '<td>'.($row['code_use']?'<span class="color-red">사용</span>':'<span class="color-gray">사용안함</span>').'</td>';
						echo '<td'.(!$row['code_use']?' class="color-gray"':'').'>'.$row['code_id'].'</td>';
						echo '<td'.(!$row['code_use']?' class="color-gray"':'').'>'.$row['code_name'].'</td>';
						echo '<td class="td_mng td_mns_m">';
							echo '<a href="./membercodeform.php?w=u&amp;code_num='.$row['code_num'].'" class="btn btn_03">수정</a>';
							echo '<a href="./membercodeformupdate.php?w=d&amp;code_num='.$row['code_num'].'" onclick="return delete_confirm(this);" class="btn btn_02">삭제</a>';
						echo '</td>';
					echo '</tr>';
				}
				if($i==0) echo '<tr><td colspan="8" class="empty_table">등록된 기업코드가 없습니다.</td></tr>';
				?>
			</tbody>
		</table>
	</div>

	<div class="btn_fixed_top">
		<a href="./membercodeform.php" class="btn btn_01">기업코드 등록</a>
	</div>

	<?=$write_pages?>

</section>
<?php } ?>



<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');