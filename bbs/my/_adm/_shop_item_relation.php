<?php
if (!defined('_GNUBOARD_')) exit;
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_item_relation_update.php" onsubmit="return _adm_relation_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="it_id" value="<?=$_GET['it_id']?>">
<input type="hidden" name="close" value="<?=$_GET['close']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<div class="_compare_wrap">
	<section class="compare_left mybox gray">
		<h3 class="mybox-label">상품 검색</h3>
		<label for="sch_relation" class="sound_only">상품분류</label>
		<span class="srel_pad">
			<select id="sch_relation">
				<option value=''>분류별 상품</option>
				<option value='all'>- 모든상품 -</option>
				<?php
					$sql = " select * from {$g5['g5_shop_category_table']} ";
					if ($is_admin != 'super')
						$sql .= " where ca_mb_id = '{$member['mb_id']}' ";
					$sql .= " order by ca_order, ca_id ";
					$result = sql_query($sql);
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$len = strlen($row['ca_id']) / 2 - 1;

						$nbsp = "";
						for ($i=0; $i<$len; $i++)
							$nbsp .= "&nbsp;&nbsp;&nbsp;";

						echo "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";
					}
				?>
			</select>
			<label for="sch_name" class="sound_only">상품명</label>
			<input type="text" name="sch_name" id="sch_name" class="frm_input" size="15">
			<button type="button" id="btn_search_item" class="btn_frmline">검색</button>
		</span>
		<div id="relation" class="srel_list _item_list">
			<p class="msg">상품의 분류를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>
		</div>
		<script>
		$(function() {
			$("#btn_search_item").click(function() {
				var ca_id = $("#sch_relation").val();
				var it_name = $.trim($("#sch_name").val());
				var $relation = $("#relation");

				if(ca_id == "" && it_name == "") {
					$relation.html("<p class='msg'>상품의 분류를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>");
					return false;
				}

				$("#relation").load(
					"<?=G5_ADMIN_URL?>/shop_admin/itemformrelation.php",
					{ it_id: "<?php echo $it_id; ?>", ca_id: ca_id, it_name: it_name }
				);
			});

			$(document).on("click", "#relation .add_item", function() {
				// 이미 등록된 상품인지 체크
				var $li = $(this).closest("li");
				var it_id = $li.find("input:hidden").val();
				var it_id2;
				var dup = false;
				$("#reg_relation input[name='re_it_id[]']").each(function() {
					it_id2 = $(this).val();
					if(it_id == it_id2) {
						dup = true;
						return false;
					}
				});

				if(dup) {
					alert("이미 선택된 상품입니다.");
					return false;
				}

				var cont = "<li>"+$li.html().replace("add_item", "del_item").replace("추가", "삭제")+"</li>";
				var count = $("#reg_relation li").length;

				if(count > 0) {
					$("#reg_relation li:last").after(cont);
				} else {
					$("#reg_relation").html("<ul>"+cont+"</ul>");
				}

				$li.remove();
			});

			$(document).on("click", "#reg_relation .del_item", function() {
				if(!confirm("상품을 삭제하시겠습니까?"))
					return false;

				$(this).closest("li").remove();

				var count = $("#reg_relation li").length;
				if(count < 1)
					$("#reg_relation").html("<p class='msg'>선택된 상품이 없습니다.</p>");
			});
		});
		</script>
	</section>

	<section class="compare_right mybox blue">
		<h3 class="mybox-label">선택된 관련상품</h3>
		<span class="srel_pad"></span>
		<div id="reg_relation" class="srel_sel _item_list">
			<?php
			$str = array();
			$sql = " select b.ca_id, b.it_id, b.it_name, b.it_price
					   from {$g5['g5_shop_item_relation_table']} a
					   left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id)
					  where a.it_id = '$it_id'
					  order by ir_no asc ";
			$result = sql_query($sql);
			for($g=0; $row=sql_fetch_array($result); $g++) {
				$it_name = get_it_image($row['it_id'], 50, 50).' '.$row['it_name'];

				if($g==0)
					echo '<ul>';
			?>
				<li>
					<input type="hidden" name="re_it_id[]" value="<?php echo $row['it_id']; ?>">
					<div class="list_item"><?php echo $it_name; ?></div>
					<div class="list_item_btn"><button type="button" class="del_item btn_frmline">삭제</button></div>
				</li>
			<?php
				$str[] = $row['it_id'];
			}
			$str = implode(",", $str);

			if($g > 0)
				echo '</ul>';
			else
				echo '<p class="msg">선택된 상품이 없습니다.</p>';
			?>
		</div>
		<input type="hidden" name="it_list" value="<?php echo $str; ?>">
	</section>

</div>



<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
function _adm_relation_form_submit(f){

	// 관련상품처리
    var item = new Array();
    var re_item = it_id = "";

    $("#reg_relation input[name='re_it_id[]']").each(function() {
        it_id = $(this).val();
        if(it_id == "")
            return true;

        item.push(it_id);
    });

    if(item.length > 0)
        re_item = item.join();

    $("input[name=it_list]").val(re_item);

    return true;
}
</script>