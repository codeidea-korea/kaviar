<?php
if (!defined('_GNUBOARD_')) exit;
?>

<form name="feventform" action="./itemeventformupdate.php" onsubmit="return feventform_check(this);" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="ev_id" value="<?php echo $ev_id; ?>">
<input type="hidden" name="ev_item" value="">

<section class="mybox blue">
	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption><?php echo $g5['title']; ?></caption>
		<colgroup>
			<col class="grid_4">
			<col>
		</colgroup>
		<tbody>
		<?php if ($w == "u") { ?>
		<tr>
			<th>이벤트번호</th>
			<td>
				<span class="frm_ev_id"><?php echo $ev_id; ?></span>
				<a href="<?php echo G5_SHOP_URL; ?>/event.php?ev_id=<?php echo $ev['ev_id']; ?>" class="btn_frmline">이벤트바로가기</a>
				<button type="button" class="btn_frmline shop_event">테마설정 가져오기</button>
			</td>
		</tr>
		<?php } ?>
		<?php if(G5_IS_MOBILE) { ?>
		<input type="hidden" name="ev_skin" value="<?=$ca['ev_skin']?>">
		<?php } else { ?>
		<tr>
			<th scope="row"><label for="ev_skin">출력스킨</label></th>
			<td>
				<?php echo help('기본으로 제공하는 스킨은 '.str_replace(G5_PATH.'/', '', G5_SHOP_SKIN_PATH).'/list.*.skin.php 입니다.'.PHP_EOL.G5_SHOP_DIR.'/event.php?ev_id=1234567890&amp;skin=userskin.php 처럼 직접 만든 스킨을 사용할 수도 있습니다.'); ?>
				<select name="ev_skin" id="ev_skin">
					<?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $ev['ev_skin']); ?>
				</select>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<th scope="row"><label for="ev_mobile_skin">모바일 출력스킨</label></th>
			<td>
				<?php echo help('기본으로 제공하는 스킨은 '.str_replace(G5_PATH.'/', '', G5_MSHOP_SKIN_PATH).'/list.*.skin.php 입니다.'.PHP_EOL.G5_SHOP_DIR.'/event.php?ev_id=1234567890&amp;skin=userskin.php 처럼 직접 만든 스킨을 사용할 수도 있습니다.'); ?>
				<select name="ev_mobile_skin" id="ev_mobile_skin">
					<?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", G5_MSHOP_SKIN_PATH, $ev['ev_mobile_skin']); ?>
				</select>
			</td>
		</tr>
		<?php if(G5_IS_MOBILE) { ?>
		<input type="hidden" name="ev_img_width" value="<?=$ca['ev_img_width']?>">
		<input type="hidden" name="ev_img_height" value="<?=$ca['ev_img_height']?>">
		<input type="hidden" name="ev_list_mod" value="<?=$ca['ev_list_mod']?>">
		<input type="hidden" name="ev_list_row" value="<?=$ca['ev_list_row']?>">
		<?php } else { ?>		
		<tr>
			<th scope="row"><label for="ev_img_width">출력이미지 폭</label></th>
			<td>
				  <input type="text" name="ev_img_width" value="<?php echo $ev['ev_img_width']; ?>" id="ev_img_width" required class="required frm_input" size="5" data-label-right="PX">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_img_height">출력이미지 높이</label></th>
			<td>
			  <input type="text" name="ev_img_height" value="<?php echo $ev['ev_img_height']; ?>" id="ev_img_height" required class="required frm_input" size="5" data-label-inline="PX">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_list_mod">1줄당 이미지 수</label></th>
			<td>
				<?php echo help("1행에 설정한 값만큼의 상품을 출력합니다. 스킨 설정에 따라 1행에 하나의 상품만 출력할 수도 있습니다."); ?>
				<input type="text" name="ev_list_mod" value="<?php echo $ev['ev_list_mod']; ?>" id="ev_list_mod" required class="required frm_input" size="3" data-label-inline="개">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_list_row">이미지 줄 수</label></th>
			<td>
				<?php echo help("한 페이지에 출력할 이미지 줄 수를 설정합니다.\n한 페이지에 표시되는 상품수는 (1줄당 이미지 수 x 줄 수) 입니다."); ?>
				<input type="text" name="ev_list_row" value="<?php echo $ev['ev_list_row']; ?>" id="ev_list_row" required class="required frm_input" size="3" data-label-inline="줄">
			</td>
		</tr>
		<?php } ?>
		<tr>
			<th scope="row"><label for="ev_mobile_img_width">모바일 출력이미지 폭</label></th>
			<td>
				  <input type="text" name="ev_mobile_img_width" value="<?php echo $ev['ev_mobile_img_width']; ?>" id="ev_mobile_img_width" required class="required frm_input" size="5" data-label-inline="PX">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_mobile_img_height">모바일 출력이미지 높이</label></th>
			<td>
			  <input type="text" name="ev_mobile_img_height" value="<?php echo $ev['ev_mobile_img_height']; ?>" id="ev_mobile_img_height" required class="required frm_input" size="5" data-label-inline="PX">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_mobile_list_mod">모바일 1줄당 이미지 수</label></th>
			<td>
				<?php echo help("1행에 설정한 값만큼의 상품을 출력합니다. 스킨 설정에 따라 1행에 하나의 상품만 출력할 수도 있습니다."); ?>
				<input type="text" name="ev_mobile_list_mod" value="<?php echo $ev['ev_mobile_list_mod']; ?>" id="ev_mobile_list_mod" required class="required frm_input" size="3" data-label-inline="개">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_mobile_list_row">모바일 이미지 줄 수</label></th>
			<td>
				<?php echo help("한 페이지에 출력할 이미지 줄 수를 설정합니다.\n한 페이지에 표시되는 상품수는 (1줄당 이미지 수 x 줄 수) 입니다."); ?>
				<input type="text" name="ev_mobile_list_row" value="<?php echo $ev['ev_mobile_list_row']; ?>" id="ev_mobile_list_row" required class="required frm_input" size="3" data-label-inline="줄">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_use">사용</label></th>
			<td>
				<?php echo help("사용하지 않으면 레이아웃의 이벤트 메뉴 및 이벤트 관련 페이지에 접근할 수 없습니다."); ?>
				<select name="ev_use" id="ev_use">
					<option value="1" <?php echo get_selected($ev['ev_use'], 1); ?>>사용</option>
					<option value="0" <?php echo get_selected($ev['ev_use'], 0); ?>>사용안함</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_subject">이벤트제목</label></th>
			<td>
				<input type="text" name="ev_subject" value="<?php echo htmlspecialchars2($ev['ev_subject']); ?>" id="ev_subject" required class="required frm_input"  size="60">
				<input type="checkbox" name="ev_subject_strong" value="1" id="ev_subject_strong" <?php if($ev['ev_subject_strong']) echo 'checked="checked"'; ?> data-label="제목 강조" data-class="ml20">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_subject">이벤트 시작일</label></th>
			<td>
				<div class="flex flex-middle gap15">
					<input type="text" name="ev_begin_time" value="<?=$ev['ev_begin_time']!='0000-00-00 00:00:00'?$ev['ev_begin_time']:''?>" id="ev_begin_time" class="frm_input"  size="21" maxlength="19">
					<input type="checkbox" name="bn_begin_chk" value="<?php echo date("Y-m-d 00:00:00", time()); ?>" id="bn_begin_chk" onclick="if (this.checked == true) this.form.ev_begin_time.value=this.form.bn_begin_chk.value; else this.form.ev_begin_time.value = this.form.ev_begin_time.defaultValue;" data-label="오늘">
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_subject">이벤트 종료일</label></th>
			<td>
				<div class="flex flex-middle gap15">
					<input type="text" name="ev_end_time" value="<?=$ev['ev_end_time']!='0000-00-00 00:00:00'?$ev['ev_end_time']:''?>" id="ev_end_time" class="frm_input" size=21 maxlength=19>
					<input type="checkbox" name="bn_end_chk" value="<?php echo date("Y-m-d 23:59:59", time()+60*60*24*31); ?>" id="bn_end_chk" onclick="if (this.checked == true) this.form.ev_end_time.value=this.form.bn_end_chk.value; else this.form.ev_end_time.value = this.form.ev_end_time.defaultValue;" data-label="오늘+31일">
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_mimg">배너이미지</label></th>
			<td>
				<?php echo help("쇼핑몰 레이아웃에서 글자 대신 이미지로 출력할 경우 사용합니다."); ?>
				<input type="file" name="ev_mimg" id="ev_mimg" class="myfile">
				<div class="banner_or_img upImg">
					<?php
					$mimg_str = "";
					$mimg = G5_DATA_PATH.'/event/'.$ev['ev_id'].'_m';
					if (file_exists($mimg)) {
						$size = @getimagesize($mimg);
						if($size[0] && $size[0] > 750)
							$width = 750;
						else
							$width = $size[0];
						
						$mimg_str = '<img src="'.get_url(G5_DATA_URL.'/event/'.$ev['ev_id'].'_m').'" width="'.$width.'" alt="">';
						$mimg_str .= '<input type="checkbox" name="ev_mimg_del" value="1" id="ev_mimg_del"> <label for="ev_mimg_del">삭제</label>';
					}
					if ($mimg_str) echo $mimg_str;
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_mimg">이벤트 배너 링크</label></th>
			<td>
				<p class="help-block">별도 링크가 있는 이벤트배너는 이벤트 상세가 아닌 링크로 이동합니다.</p>
				<div class="flex flex-middle gap10">
					<?php
					$ev_banner_link = explode("|", $ev['ev_banner_link']);
					echo '<select name="ev_banner_link[]" class="selectpicker min160" id="linkChoice">';
						echo option_selected('', $ev_banner_link[0], "배너링크 선택 (직접입력)", "");
						echo option_selected_my('_page', $ev_banner_link[0], "블럭 페이지", "data-content='<b>블럭 페이지</b>'");
					echo '</select>';
					echo '<label id="_eventLink" class="labelInput flex1"><span class="label">'.($ev_banner_link[0] == '_page'?'페이지명':'링크').'</span><input type="text" name="ev_banner_link[]" value="'.$ev_banner_link[1].'" class="w-full" placeholder="http://"></label>';
					echo '<div id="_eventLinkOption"'.($ev_banner_link[0]=='_page'?' style="display:none"':'').'>';
						echo '<select name="ev_banner_link[]" class="selectpicker">';
							echo option_selected("", $ev_banner_link[2], "바로가기");
							echo option_selected("_blank", $ev_banner_link[2], "새창열기");
						echo '</select>';
					echo '</div>';
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row">관련상품</th>
			<td id="sev_it_rel" class="compare_wrap srel">

				<section class="compare_left">
					<h3>상품검색</h3>
					<span class="srel_pad">
						<select name="ca_id" id="sch_ca_id">
							<option value="">분류선택</option>
							<?php echo $category_select; ?>
						</select>
						<label for="sch_name" class="sound_only">상품명</label>
						<input type="text" name="sch_name" id="sch_name" class="frm_input" size="15">
						<button type="button" id="btn_search_item" class="btn_frmline">검색</button>
					</span>
					<div id="sch_item_list" class="srel_list">
						<p>상품의 분류를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>
					</div>
				</section>

				<section class="compare_right">
					<h3>등록된 상품</h3>
					<span class="srel_pad"></span>
					<div id="reg_item_list" class="srel_sel">
						<?php
						if( $res_item ) {
						for($i=0; $row=sql_fetch_array($res_item); $i++) {
							$it_name = get_it_image($row['it_id'], 50, 50).' '.$row['it_name'];

							if($i==0)
								echo '<ul>';
						?>
							<li>
								<input type="hidden" name="it_id[]" value="<?php echo $row['it_id']; ?>">
								<div class="list_item"><?php echo $it_name; ?></div>
								<div class="list_item_btn"><button type="button" class="del_item btn_frmline">삭제</button></div>
							</li>
						<?php
						}   // end for
						}   // end if
						if($i > 0)
							echo '</ul>';
						else
							echo '<p>등록된 상품이 없습니다.</p>';
						?>
					</div>
				</section>
			</td>
		</tr>
		<!--<tr>
			<th scope="row"><label for="ev_himg">상단이미지</label></th>
			<td>
				<?php echo help("이벤트 페이지 상단에 업로드 한 이미지를 출력합니다."); ?>
				<input type="file" name="ev_himg" id="ev_himg" class="myfile">
				<div class="banner_or_img upImg">
					<?php
					$himg_str = "";
					$himg = G5_DATA_PATH.'/event/'.$ev['ev_id'].'_h';
					if (file_exists($himg)) {
						$size = @getimagesize($himg);
						if($size[0] && $size[0] > 750)
							$width = 750;
						else
							$width = $size[0];
						
						$himg_str = '<img src="'.G5_DATA_URL.'/event/'.$ev['ev_id'].'_h" width="'.$width.'" alt="">';
						$himg_str .= '<input type="checkbox" name="ev_himg_del" value="1" id="ev_himg_del"><label for="ev_himg_del">삭제</label>';
					}
					if ($himg_str) echo $himg_str;
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ev_timg">하단이미지</label></th>
			<td>
				<?php echo help("이벤트 페이지 하단에 업로드 한 이미지를 출력합니다."); ?>
				<input type="file" name="ev_timg" id="ev_timg" class="myfile">
				<div class="banner_or_img upImg">
					<?php
					$timg_str = "";
					$timg = G5_DATA_PATH.'/event/'.$ev['ev_id'].'_t';
					if (file_exists($timg)) {
						$size = @getimagesize($timg);
						if($size[0] && $size[0] > 750)
							$width = 750;
						else
							$width = $size[0];
						
						$timg_str = '<img src="'.G5_DATA_URL.'/event/'.$ev['ev_id'].'_t" width="'.$width.'" alt="">';
						$timg_str .= '<input type="checkbox" name="ev_timg_del" value="1" id="ev_timg_del"><label for="ev_timg_del">삭제</label>';
					}
					if ($timg_str) echo $timg_str;
					?>
				</div>
			</td>
		</tr>-->
		<tr>
			<th scope="row">상단내용</th>
			<td>
				<?php echo editor_html('ev_head_html', get_text(html_purifier($ev['ev_head_html']), 0)); ?>
			</td>
		</tr>
		<tr>
			<th scope="row">하단내용</th>
			<td>
				<?php echo editor_html('ev_tail_html', get_text(html_purifier($ev['ev_tail_html']), 0)); ?>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
</section>

<div class="btn_fixed_top">
    <a href="./itemevent.php" class="btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
function linkChoice(el) {
	var val = $(el).find("option:selected").val(),
		eventLink = $('#_eventLink'),
		eventLinkOption = $('#_eventLinkOption'),			
		eventLink_label = eventLink.find('.label');
	if(val == '_page') {
		eventLink_label.html('페이지명');
		eventLinkOption.hide();
		eventLink.find('input').attr("placeholder" , '');
		eventLink.find('input').attr("required" , true);
	} else {
		eventLink_label.html('링크');
		eventLinkOption.show();
		eventLink.find('input').attr("placeholder" , 'http://');
		eventLink.find('input').attr("required" , false);
	}
}

$(document).ready(function(){
	linkChoice('#linkChoice');
});
$('#linkChoice').on("change", function(){
	linkChoice($(this));
});
</script>

<script>
$(function() {
    $(".shop_event").on("click", function() {
        if(!confirm("현재 테마의 스킨, 이미지 사이즈 등의 설정을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "../theme_config_load.php",
            cache: false,
            async: false,
            data: { type: 'shop_event' },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                $.each(data, function(key, val) {
                    if(key == "error")
                        return true;

                    $("#"+key).val(val);
                });
            }
        });
    });

    $("#btn_search_item").click(function() {
        var ca_id = $("#sch_ca_id").val();
        var it_name = $.trim($("#sch_name").val());

        if(ca_id == "" && it_name == "") {
            $("#sch_item_list").html("<p>상품의 분류를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>");
            return false;
        }

        $("#sch_item_list").load(
            "./itemeventsearch.php",
            { w: "<?php echo $w; ?>", ev_id: "<?php echo $ev_id; ?>", ca_id: ca_id, it_name: it_name }
        );
    });

    $(document).on("click", "#sch_item_list .add_item", function() {
        // 이미 등록된 상품인지 체크
        var $li = $(this).closest("li");
        var it_id = $li.find("input:hidden").val();
        var it_id2;
        var dup = false;
        $("#reg_item_list input[name='it_id[]']").each(function() {
            it_id2 = $(this).val();
            if(it_id == it_id2) {
                dup = true;
                return false;
            }
        });

        if(dup) {
            alert("이미 등록된 상품입니다.");
            return false;
        }

        var cont = "<li>"+$li.html().replace("add_item", "del_item").replace("추가", "삭제")+"</li>";
        var count = $("#reg_item_list li").length;

        if(count > 0) {
            $("#reg_item_list li:last").after(cont);
        } else {
            $("#reg_item_list").html("<ul>"+cont+"</ul>");
        }

        $li.remove();
    });

    $(document).on("click", "#reg_item_list .del_item", function() {
        if(!confirm("상품을 삭제하시겠습니까?"))
            return false;

        $(this).closest("li").remove();

        var count = $("#reg_item_list li").length;
        if(count < 1)
            $("#reg_item_list").html("<p>등록된 상품이 없습니다.</p>");
    });
});
function feventform_check(f)
{
    var item = new Array();
    var ev_item = it_id = "";

    $("#reg_item_list input[name='it_id[]']").each(function() {
        it_id = $(this).val();
        if(it_id == "")
            return true;

        item.push(it_id);
    });

    if(item.length > 0)
        ev_item = item.join();

    $("input[name=ev_item]").val(ev_item);

    <?php echo get_editor_js('ev_head_html'); ?>
    <?php echo get_editor_js('ev_tail_html'); ?>

    return true;
}

/* document.feventform.ev_subject.focus(); 포커스해제*/
</script>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');