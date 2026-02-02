<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists(G5_THIS_SHOP_SKIN_PATH.'/item.info.skin.php')) {
	require_once(G5_THIS_SHOP_SKIN_PATH.'/item.info.skin.php');
	return;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_SHOP_SKIN_URL.'/skin.css').'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<?php if ($default['de_rel_list_use']) { ?>
<section id="sit_rel">
    <h2>관련상품</h2>
    <?php
    //$rel_skin_file = $skin_dir.'/'.$default['de_rel_list_skin'];
    //if(!is_file($rel_skin_file))
        //$rel_skin_file = G5_SHOP_SKIN_PATH.'/'.$default['de_rel_list_skin'];

    $sql = " select b.* from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
    //$list = new item_list($rel_skin_file, $default['de_rel_list_mod'], 0, $default['de_rel_img_width'], $default['de_rel_img_height']);
    //$list->set_query($sql);
    //echo $list->run();
	$list_file = G5_SHOP_SKIN_PATH.'/_block_item.skin.php';
	$list = new item_list();
	$list->set_query($sql);
	$list->set_list_skin($list_file);
	$list->set_img_size($default['de_rel_img_width'], $default['de_rel_img_height']);
	$list->set_items_cols($default['de_rel_list_mod']);
	$list->set_items_gap(25);
	$list->set_items_radius(6);
	$list->set_items_skin('_slide');
	echo $list->run();
    ?>
</section>
<?php } ?>

<?php
if(shop_banner('상품상세', '_block_banner.skin.php')) {
	echo '<section id="item_banner" class="relative">';
		echo shop_banner('상품상세', '_block_banner.skin.php');
		if($is_shop_manager) echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=상품상세&title=쇼핑몰 배너관리" class="edit-block btnSetting popWin" data-width="1250" data-height="600" data-top="60" data-left="0" data-area="#mypage_banner">쇼핑몰 배너관리</a>';
	echo '</section>';
}
?>

<section id="sit_info">
	<div id="sit_tab">
	    <ul class="tab_tit">
	        <li><button type="button" id="btn_sit_inf" rel="#sit_inf" class="selected">상품정보</button></li>
	        <li><button type="button" id="btn_sit_use" rel="#sit_use">사용후기 <span class="item_use_count">(<?php echo $item_use_count; ?>)</span></button></li>
	        <li><button type="button" id="btn_sit_qa" rel="#sit_qa">상품문의  <span class="item_qa_count">(<?php echo $item_qa_count; ?>)</span></button></li>
	        <li><button type="button" id="btn_sit_dvex" rel="#sit_dex">배송/교환</button></li>
	    </ul>
	    <ul class="tab_con">
	
	        <!-- 상품 정보 시작 { -->
	        <li id="sit_inf">
	            <h2 class="contents_tit"><span>상품 정보</span></h2>	
	            <?php
				$it_img_url = G5_DATA_URL.'/file/'.$default['de_item_list_top_img'];
				if($default['de_item_list_top_img']){
					echo '<img src="'.$it_img_url.'">';
				}
				if ($it['it_explan']) { // 상품 상세설명
					echo '<div id="sit_inf_explan">'.conv_content($it['it_explan'], 1).'</div>';
	            }
				/*if($it['it_info_value']) { // 상품 정보 고시
	                $info_data = unserialize(stripslashes($it['it_info_value']));
	                if(is_array($info_data)) {
	                    $gubun = $it['it_info_gubun'];
	                    $info_array = $item_info[$gubun]['article'];
	           
						echo '<h3>상품 정보 고시</h3>';
						echo '<table id="sit_inf_open">';
							echo '<tbody>';
								foreach($info_data as $key=>$val) {
									$ii_title = $info_array[$key][0];
									$ii_value = $val;
				   
									echo '<tr>';
										echo '<th scope="row">'.$ii_title.'</th>';
										echo '<td>'.$ii_value.'</td>';
									echo '</tr>';
								} //foreach
							echo '</tbody>';
						echo '</table>';
					
					} else {
	                    if($is_admin) echo '<p>상품 정보 고시 정보가 올바르게 저장되지 않았습니다.<br>config.php 파일의 G5_ESCAPE_FUNCTION 설정을 addslashes 로<br>변경하신 후 관리자 &gt; 상품정보 수정에서 상품 정보를 다시 저장해주세요. </p>';
	                }
	            }*/
	            ?>	
	        </li>
	        
	        <li id="sit_use">
	            <h2>사용후기</h2>
	            <div id="itemuse"><?php include_once(G5_SHOP_PATH.'/itemuse.php'); ?></div>
	        </li>

	        <li id="sit_qa">
	            <h2>상품문의</h2>
	            <div id="itemqa"><?php include_once(G5_SHOP_PATH.'/itemqa.php'); ?></div>
	        </li>

	        <li id="sit_dex">
	            <h2>배송/교환정보</h2>	            
	            <?php
				if($default['de_baesong_content']) { // 배송정보 내용이 있다면
					echo '<div id="sit_dvr">';
						echo '<h3>배송</h3>';
						echo conv_content($default['de_baesong_content'], 1);
					echo '</div>';
				}
				if($default['de_change_content']) { // 교환/반품 내용이 있다면
					echo '<div id="sit_ex">';
						echo '<h3>교환</h3>';
						echo conv_content($default['de_change_content'], 1);
					echo '</div>';
	            } ?>	            
	        </li>
	    </ul>
	</div>
	<script>
	$(function (){
		$(".tab_tit li button").click(function(){
			var offset = $($(this).attr("rel")).offset();
			$('html, body').animate({scrollTop:offset.top - 80}, 0);
	    });
	    /*$(".tab_con>li").hide();
	    $(".tab_con>li:first").show();   
	    $(".tab_tit li button").click(function(){
	        $(".tab_tit li button").removeClass("selected");
	        $(this).addClass("selected");
	        $(".tab_con>li").hide();
	        $($(this).attr("rel")).show();
	    });*/
	});
	</script>
	<div id="sit_buy" class="fix">
		<div class="sit_buy_inner">
	        <?php
			if($option_item) { // 선택옵션이 있다면
				echo '<section class="sit_side_option">';
					echo str_replace(array('class="get_item_options"', 'id="it_option_', 'class="it_option"'), array('class="get_side_item_options"', 'id="it_side_option_', 'class="it_side_option"'), $option_item);	           
				echo '</section>';
			} // end if
			if($supply_item) { // 추가옵션이 있다면
				echo '<section class="sit_side_option">';
					echo str_replace(array('id="it_supply_', 'class="it_supply"'), array('id="it_side_supply_', 'class="it_side_supply"'), $supply_item);
				echo '</section>';
	        } // end if
            
            if($is_orderable) { //선택된 옵션 시작
				echo '<section class="sit_sel_option">';
					echo '<ul class="sit_opt_added" class="sit_opt_added">';
						if(!$option_item) {
							echo '<li>';
								echo '<div class="opt_name">';
									echo '<span class="sit_opt_subj">'.$it['it_name'].'</span>';
								echo '</div>';
								echo '<div class="opt_count">';
									echo '<label for="ct_qty_'.$i.'" class="sound_only">수량</label>';
									echo '<button type="button" class="sit_qty_minus"><span class="sound_only">감소</span></button>';
									echo '<input type="text" name="ct_copy_qty['.$it_id.'][]" value="'.$it['it_buy_min_qty'].'" id="ct_qty_'.$i.'" class="num_input" size="5" readonly>';
									echo '<button type="button" class="sit_qty_plus"><span class="sound_only">증가</span></button>';
									//echo '<span class="sit_opt_prc">+0원</span>';
									echo '<span class="sit_opt_prc">+'.display_price(get_price($it)).'</span>';
								echo '</div>';
							echo '</li>';
						}
					echo '</ul>';
				echo '</section>';

				echo '<div class="sum_section">';      
					//echo '<div class="sit_tot_price"></div>';
					echo '<div class="sit_tot_price"><span>총 금액 </span><strong>'.number_format(get_price($it), 0).'</strong>원</div>';
					
					
					echo '<div class="sit_order_btn">';
						echo '<button type="submit" onclick="document.pressed=this.value;" value="장바구니" class="sit_btn_cart">장바구니</button>';
						echo '<button type="submit" onclick="document.pressed=this.value;" value="바로구매" class="sit_btn_buy">바로구매</button> ';
				   echo '</div>';
				echo '</div>';
            }
			?>
			
	    </div>   
	</div>
</section>

<script>

$(document).ready(function(){
	
	
	$(window).scroll(function() {
		if( $(this).scrollTop() >= $('#sit_info').offset().top - 80) {
			$('#sit_buy').addClass('scroll-fix');
			$('.hide_searchContainer').hide();
		} else {
			$('#sit_buy').removeClass('scroll-fix');
		}
	});

});



$('#sit_buy select').selectpicker();  //인태

jQuery(function($){
    var change_name = "ct_copy_qty";

    $(document).on("select_it_option_change", "select.it_option", function(e, $othis) {
        var value = $othis.val(),
            change_id = $othis.attr("id").replace("it_option_", "it_side_option_");
        
        if( $("#"+change_id).length ){
            $("#"+change_id).val(value).attr("selected", "selected");
        }
    });

    $(document).on("select_it_option_post", "select.it_option", function(e, $othis, idx, sel_count, data) {
        var value = $othis.val(),
            change_id = $othis.attr("id").replace("it_option_", "it_side_option_");
        
        $("select.it_side_option").eq(idx+1).empty().html(data).attr("disabled", false);

        // select의 옵션이 변경됐을 경우 하위 옵션 disabled
        if( (idx+1) < sel_count) {
            $("select.it_side_option:gt("+(idx+1)+")").val("").attr("disabled", true);
        }
    });

    $(document).on("add_sit_sel_option", "#sit_sel_option", function(e, opt) {
        
        opt = opt.replace('name="ct_qty[', 'name="'+change_name+'[');

        var $opt = $(opt);
        $opt.removeClass("sit_opt_list");
        $("input[type=hidden]", $opt).remove();

        $(".sit_sel_option .sit_opt_added").append($opt);

    });

    $(document).on("price_calculate", "#sit_tot_price", function(e, total) {

        $(".sum_section .sit_tot_price").empty().html("<span>총 금액 </span><strong>"+number_format(String(total))+"</strong> 원");

    });

    $(".sit_side_option").on("change", "select.it_side_option", function(e) {
        var idx = $("select.it_side_option").index($(this)),
            value = $(this).val();

        if( value ){
            if (typeof(option_add) != "undefined"){
                option_add = true;
            }

            $("select.it_option").eq(idx).val(value).attr("selected", "selected").trigger("change");
        }
    });

    $(".sit_side_option").on("change", "select.it_side_supply", function(e) {
        var value = $(this).val();

        if( value ){
            if (typeof(supply_add) != "undefined"){
                supply_add = true;
            }

            $("select.it_supply").val(value).attr("selected", "selected").trigger("change");
        }
    });

    $(".sit_opt_added").on("click", "button", function(e){
        e.preventDefault();

        var $this = $(this),
            mode = $this.text(),
            $sit_sel_el = $("#sit_sel_option"),
            li_parent_index = $this.closest('li').index();
        
        if( ! $sit_sel_el.length ){
            alert("el 에러");
            return false;
        }

        switch(mode) {
            case "증가":
                $sit_sel_el.find("li").eq(li_parent_index).find(".sit_qty_plus").trigger("click");
                break;
            case "감소":
                $sit_sel_el.find("li").eq(li_parent_index).find(".sit_qty_minus").trigger("click");
                break;
            case "삭제":
                $sit_sel_el.find("li").eq(li_parent_index).find(".sit_opt_del").trigger("click");
                break;
        }

    });

    $(document).on("sit_sel_option_success", "#sit_sel_option li button", function(e, $othis, mode, this_qty, opt_price) {
        var ori_index = $othis.closest('li').index();

        switch(mode) {
            case "증가":
				$(".sit_opt_added li").eq(ori_index).find(".sit_opt_prc").html(opt_price);
            case "감소":
                $(".sit_opt_added li").eq(ori_index).find("input[name^=ct_copy_qty]").val(this_qty);
				$(".sit_opt_added li").eq(ori_index).find(".sit_opt_prc").html(opt_price);
                break;
            case "삭제":
                $(".sit_opt_added li").eq(ori_index).remove();
                break;
        }
    });

    $(document).on("change_option_qty", "input[name^=ct_qty]", function(e, $othis, val, force_val) {
        var $this = $(this),
            ori_index = $othis.closest('li').index(),
            this_val = force_val ? force_val : val;

        $(".sit_opt_added").find("li").eq(ori_index).find("input[name^="+change_name+"]").val(this_val);
    });

    $(".sit_opt_added").on("keyup paste", "input[name^="+change_name+"]", function(e) {
         var $this = $(this),
             val= $this.val(),
             this_index = $("input[name^="+change_name+"]").index(this);

         $("input[name^=ct_qty]").eq(this_index).val(val).trigger("keyup");
    });

    $(".sit_order_btn").on("click", "button", function(e){
        e.preventDefault();

        var $this = $(this);

        if( $this.hasClass("sit_btn_cart") ){
            $("#sit_ov_btn .sit_btn_cart").trigger("click");
        } else if ( $this.hasClass("sit_btn_buy") ) {
            $("#sit_ov_btn .sit_btn_buy").trigger("click");
        }
    });

	if (window.location.href.split("#").length > 1) {
		let id = window.location.href.split("#")[1];
		$("#btn_" + id).trigger("click");
	};
});
</script>