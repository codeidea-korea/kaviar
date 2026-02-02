<?php
if (!defined('_GNUBOARD_')) exit;
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_item_event_update.php" onsubmit="return _adm_event_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="it_id" value="<?=$_GET['it_id']?>">
<input type="hidden" name="close" value="<?=$_GET['close']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<div class="_compare_wrap">
	<section class="compare_left mybox gray">
		<h3 class="mybox-label">등록된 전체이벤트</h3>
		<div id="event_list" class="srel_list srel_noneimg _item_list">
			<?php
			$sql = " select ev_id, ev_subject from {$g5['g5_shop_event_table']} order by ev_id desc ";
			$result = sql_query($sql);
			for ($g=0; $row=sql_fetch_array($result); $g++) {
				if($g == 0)
					echo '<ul>';
			?>
				<li>
					<input type="hidden" name="ev_id[]" value="<?php echo $row['ev_id']; ?>">
					<div class="list_item"><?php echo get_text($row['ev_subject']); ?></div>
					<div class="list_item_btn"><button type="button" class="add_event btn_frmline">추가</button></div>
				</li>
			<?php
			}

			if($g > 0)
				echo '</ul>';
			else
				echo '<p class="msg">등록된 이벤트가 없습니다.</p>';
			?>
		</div>
		<script>
		$(function() {
			$(document).on("click", "#event_list .add_event", function() {
				// 이미 등록된 이벤트인지 체크
				var $li = $(this).closest("li");
				var ev_id = $li.find("input:hidden").val();
				var ev_id2;
				var dup = false;
				$("#reg_event_list input[name='ev_id[]']").each(function() {
					ev_id2 = $(this).val();
					if(ev_id == ev_id2) {
						dup = true;
						return false;
					}
				});

				if(dup) {
					alert("이미 선택된 이벤트입니다.");
					return false;
				}

				var cont = "<li>"+$li.html().replace("add_event", "del_event").replace("추가", "삭제")+"</li>";
				var count = $("#reg_event_list li").length;

				if(count > 0) {
					$("#reg_event_list li:last").after(cont);
				} else {
					$("#reg_event_list").html("<ul>"+cont+"</ul>");
				}
			});

			$(document).on("click", "#reg_event_list .del_event", function() {
				if(!confirm("상품을 삭제하시겠습니까?"))
					return false;

				$(this).closest("li").remove();

				var count = $("#reg_event_list li").length;
				if(count < 1)
					$("#reg_event_list").html("<p class='msg'>선택된 이벤트가 없습니다.</p>");
			});
		});
		</script>
	</section>

	<section class="compare_right mybox blue">
		<h3 class="mybox-label">선택된 관련 이벤트</h3>
		<div id="reg_event_list" class="srel_sel srel_noneimg _item_list">
			<?php
			$str = "";
			$comma = "";
			$sql = " select b.ev_id, b.ev_subject
					   from {$g5['g5_shop_event_item_table']} a
					   left join {$g5['g5_shop_event_table']} b on (a.ev_id=b.ev_id)
					  where a.it_id = '$it_id'
					  order by b.ev_id desc ";
			$result = sql_query($sql);
			for ($g=0; $row=sql_fetch_array($result); $g++) {
				$str .= $comma . $row['ev_id'];
				$comma = ",";

				if($g == 0)
					echo '<ul>';
			?>
				<li>
					<input type="hidden" name="ev_id[]" value="<?php echo $row['ev_id']; ?>">
					<div class="list_item"><?php echo get_text($row['ev_subject']); ?></div>
					<div class="list_item_btn"><button type="button" class="del_event btn_frmline">삭제</button></div>
				</li>
			<?php
			}

			if($g > 0)
				echo '</ul>';
			else
				echo '<p class="msg">선택된 이벤트가 없습니다.</p>';
			?>
		</div>
		<input type="hidden" name="ev_list" value="<?php echo $str; ?>">
	</section>
</div>



<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
function _adm_event_form_submit(f){

	// 이벤트처리
    var evnt = new Array();
    var ev = ev_id = "";

    $("#reg_event_list input[name='ev_id[]']").each(function() {
        ev_id = $(this).val();
        if(ev_id == "")
            return true;

        evnt.push(ev_id);
    });

    if(evnt.length > 0)
        ev = evnt.join();

    $("input[name=ev_list]").val(ev);

    return true;
}
</script>