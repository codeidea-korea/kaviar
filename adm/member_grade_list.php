<?php
$sub_menu = "200150";
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from `g5_member_grade` ";

$sql_search = " where (1) ";
 

if (!$sst) {
    $sst = "idx";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

// 탈퇴회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 차단회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$intercept_count = $row['cnt'];

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '회원등급관리';
include_once('./admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan = 16;


?>

<form name="fmemberlist" id="fmemberlist" action="./member_list_update.php" onsubmit="return fmemberlist_submit(this);" method="post">
<div style="padding-bottom:20px">
    <input type="checkbox" name="cf_grade" value="1" id="cf_grade" <?php echo ($config['cf_grade']) ? "checked" : ""; ?> onclick="g_save('',1,this)"> 회원등관리 사용 유무
</div>
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" id="mb_list_chk">
            <label for="chkall" class="sound_only">회원 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
		<th scope="col" id="mb_list_mailr" >등급</a></th>
        <th scope="col" id="mb_list_mailr">회원</a></th>
        <th scope="col" id="mb_list_cert">할인율</a></th>
		<th scope="col" id="mb_list_cert">적립율</a></th>
		<th scope="col" id="mb_list_mailc">회원 자격요건</a></th>
        <th scope="col" id="mb_list_open">등급별 회원수</a></th>
        <th scope="col" id="mb_list_mailr">승급예정 회원수</a></th>
        <th scope="col" id="mb_list_mng">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {

        if ($is_admin == 'group') {
            $s_mod = '';
        } else {
            $s_mod = '<a href="./member_form.php?'.$qstr.'&amp;w=u&amp;mb_id='.$row['mb_id'].'" class="btn btn_03">수정</a>';
        }

        $mb_id = $row['mb_id'];

        $bg = 'bg'.($i%2);

    ?>

    <tr class="<?php echo $bg; ?>">
        <td headers="mb_list_chk" class="td_chk">
            <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['mb_name']); ?> <?php echo get_text($row['mb_nick']); ?>님</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
		


		<td headers="mb_list_mng" class="td_mng td_mng_s">
			<?php echo $row['idx'] ?>
		</td>
        <td headers="mb_list_auth" class="td_grade">
            <input type="text" onchange="g_save(<?=$row['idx']?>,2,this.value)" name="g_name[<?php echo $i ?>]" value="<?php echo $row['g_name'] ?>" id="g_name<?php echo $i ?>">            
        </td>

        <td headers="mb_list_auth" class="td_date">
				<select onchange="g_save(<?=$row['idx']?>,3,this.value)">
            <?php
				for ($y=0; $y<41; $y++) {
			?>
					<option value="<?=$y?>" <?=($y==$row['g_discount']?"selected":"")?>><?=$y?>%</option>
			<?
				}
			?>
				</select>
        </td>
		<td headers="mb_list_auth" class="td_date">
				<select onchange="g_save(<?=$row['idx']?>,4,this.value)" id="me_target_<?php echo $i; ?>" style="width:100px">
            <?php
				for ($y=0; $y<41; $y++) {
			?>
					<option value="<?=$y?>"<?=($y==$row['g_reward']?"selected":"")?>><?=$y?>%</option>
			<?
				}
			?>
				</select>
        </td>
        <td headers="mb_list_mobile" class="td_grade">
			<input type="text" onchange="g_save(<?=$row['idx']?>,5,this.value)" style="width:100px" name="g_reward_start[<?php echo $i ?>]" value="<?php echo number_format($row['g_reward_start']) ?>" id="g_reward_start<?php echo $i ?>">
			~
			<input type="text" onchange="g_save(<?=$row['idx']?>,6,this.value)" style="width:100px" name="g_reward_end[<?php echo $i ?>]" value="<?php echo number_format($row['g_reward_end']) ?>" id="g_reward_end<?php echo $i ?>">

		</td>
        <td headers="mb_list_lastcall" class="td_date">
			
		</td>
        <td headers="mb_list_grp" class="td_date">
			
		</td>
        <td headers="mb_list_mng" class="td_mng td_mng_s">
			<?php echo $s_mod ?>
		</td>
    </tr>


    <?php
    }
    if ($i == 0)
        echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
    ?>
    </tbody>
    </table>
</div>
<!--
<div class="btn_fixed_top">
    <?php if ($is_admin == 'super') { ?>
    <a href="./member_form.php" id="member_add" class="btn btn_01">등급추가</a>
    <?php } ?>
</div>
-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<script>
function fmemberlist_submit(f)
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



function g_save(number,type,content)
{	

	var k = confirm("수정 하시겠습니까?");

	if(type == 1){
		if(content.checked){
			content = 1;
		}else{
			content = 0;
		}
	}

	if(k==false){
		return;

	}else{
	
		$.ajax({
		  url:'ajax.grade.php',
		  type:'POST',
		  data: {
			    'number': number,
			    'type': type,
				'content': content,
		  },

		  cache: false,
		  async: false,
		  dataType : 'json',
		  success: function(res) {
				//$('#Context').html(data);
				console.log(res);
			}
		});
	}

	//reload();
}

	function reload(){
		location.href=".php";
	}
</script>

<?php
include_once ('./admin.tail.php');