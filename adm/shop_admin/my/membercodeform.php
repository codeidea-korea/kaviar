<?php
$sub_menu = '400903';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

$g5['membercode_table'] = G5_TABLE_PREFIX.'membercode';

auth_check_menu($auth, $sub_menu, "w");

$g5['title'] = $w ? '기업코드 수정' : '기업코드 등록';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$code_num = isset($_REQUEST['code_num']) ? preg_replace('/[^0-9]/', '', $_REQUEST['code_num']) : 0;
if($code_num) {
	$sql = " select * from {$g5['membercode_table']} where code_num = '$code_num' ";
	$code = sql_fetch($sql);
}

function passnum($idsu) {
	global $g5;

	$num = array(A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,1,2,3,4,5,6,7,8,9,0);
	for($i=0; $i<$idsu; $i++) {
		$rand = rand(0,35);
		$pass .= $num[$rand];
	}
	
	$sql = " select count(*) as cnt from {$g5['membercode_table']} where code_id = '$pass' ";
	$row = sql_fetch($sql);
	$count = $row['cnt'];
	
	if($count) {
		return passnum("5"); //이미 코드가 있다면 다시 생성
	} else {
		return $pass;
	}
}
$idsu = passnum("5");
?>

<form name="membercode" action="./membercodeformupdate.php" onsubmit="return membercode_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="token" value="">
<input type="hidden" name="w" value="<?=$w?>">
<input type="hidden" name="code_num" value="<?=$code_num?>">
<input type="hidden" name="token" value="">

<section class="mybox">
    <h2 class="h2_frm"><?=$g5['title']?></h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label>사용여부</label></th>
					<td>
						<div style="--toggle-light-width:56px;--toggle-light-height:26px;">
							<input type="checkbox" name="code_use" value="1" class="toggle-light"<?=$code['code_use']||!$w?' checked':''?>>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row"><label>기업코드</label></th>
					<td>
						<p class="help-block">5자리 랜덤코드 - 새로고침시 래덤으로 5자리 영문대문자 + 숫자 조합이 생성됩니다.<br>한번 저장된 기업코드는 변경할 수 없습니다.</p>
						<input type="text" name="code_id" value="<?=$code['code_id']?$code['code_id']:$idsu?>" id="code_id" class="w-300"<?=$code['code_id']?' readOnly':''?> required placeholder="기업코드를 입력해 주세요.">
					</td>
				</tr>
				<tr>
					<th scope="row"><label>기업 이름</label></th>
					<td>
						<input type="text" name="code_name" value="<?=$code['code_name']?>" id="code_name" class="w-300" required placeholder="기업명을 입력해 주세요.">
					</td>
				</tr>
				<tr>
					<th scope="row"><label>회원가입 완료 문구</label></th>
					<td>
						<p class="help-block mb5">
							회원이름 - {name}<br>
							쇼핑몰 이름 - {company}
						</p>
						<?php echo editor_html("join_content", get_text(html_purifier($code['join_content']), 0)); ?>
					</td>
				</tr>
			</tbody>
        </table>
    </div>
</section>


<div class="btn_fixed_top">
    <a href="./membercode.php" class="btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>


<script>
function membercode_submit(f){
	<?php echo get_editor_js("join_content"); ?>
    return true;
}
</script>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');