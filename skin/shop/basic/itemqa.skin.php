<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 상품문의 목록 시작 { -->
<section id="sit_qa_list">
    <h3>등록된 상품문의</h3>
	
	<div class="sit_qa_top">
		<div class="txt">
			<h4>상품문의</h4>
			<p>
				ㆍ상품에 대한 문의를 남기는 공간입니다. 해당 게시판의 성격과 다른 글은 사전동의 없이 이동될 수 있습니다.<br>
				ㆍ배송관련, 주문(취소/교환/환불)관련 문의 및 요청사항은 마이페이지 내 1:1문의에 남겨주세요.
			</p>
		</div>
        <div id="sit_qa_wbtn">
			<a href="<?php echo $itemqa_form; ?>" class="btn02 itemqa_form">상품문의 쓰기<span class="sound_only">새 창</span></a>
			<!--<a href="<?php echo $itemqa_list; ?>" id="itemqa_list" class="btn01">더보기</a>-->
		</div>
    </div>
    

    <?php
    $thumbnail_width = 500;
    $iq_num     = $total_count - ($page - 1) * $rows;

    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $iq_name    = get_text($row['iq_name']);
		//$is_name = $is_admin2 ? $iq_name : mb_substr($iq_name,0,-2)."**";
        $iq_subject = conv_subject($row['iq_subject'],50,"…");

        $is_secret = false;
        if($row['iq_secret']) {
            //$iq_subject .= ' <img src="'.G5_SHOP_SKIN_URL.'/img/icon_secret.gif" alt="비밀글">';
			if(!$is_admin) $iq_subject = '비밀글 입니다.';

            if($is_admin || $member['mb_id' ] == $row['mb_id']) {
                $iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width);
            } else {
                $iq_question = '비밀글로 보호된 문의입니다.';
                $is_secret = true;
            }
        } else {
            $iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width);
        }
        $iq_time    = substr($row['iq_time'], 2, 8);

        $hash = md5($row['iq_id'].$row['iq_time'].$row['iq_ip']);

        $iq_stats = '';
        $iq_style = '';
        $iq_answer = '';

        if ($row['iq_answer'])         {
            $iq_answer = get_view_thumbnail(conv_content($row['iq_answer'], 1), $thumbnail_width);
            $iq_stats = '<span class="iq_stats sit_qaa_done">답변완료</span>';
            $is_answer = true;
        } else {
            $iq_stats = '<span class="iq_stats sit_qaa_yet">답변대기</span>';
            $iq_answer = '답변이 등록되지 않았습니다.';
            $is_answer = false;
        }

        if ($i == 0) echo '<ol id="sit_qa_ol">';
    ?>

        <li class="sit_qa_li">
            <button type="button" class="sit_qa_li_title<?=$row['iq_secret']?' iq_secret':''?>"><?php echo $iq_subject; ?></button>

			<div class="writer"><?=$is_admin ? $iq_name : mb_substr($iq_name,0,-2)."**"?></div>
			<div class="date"><?=$iq_time?></div>
			<?=$iq_stats?>

			<div id="sit_qa_con_<?php echo $i; ?>" class="sit_qa_con">
                <div class="sit_qa_p">
                    <div class="sit_qa_qaq">
                        <strong class="sound_only">문의내용</strong>
                        <span class="qa_alp">Q</span>
                        <?php echo $iq_question; // 상품 문의 내용 ?>

                    </div>
					<div style="padding-top:10px;display:flex;align-items: center;">
                        
						<?php	
							for($u=1; $u<=5; $u++) {
								
								if($row['iq_img'.$u] != ''){
									$it_img_urls = G5_URL."/data/shop_qa/".$row['iq_img'.$u];
									//echo "<img src='".$it_img_urls."' style='max-width:20% !important;'>";
									$f_ex = explode('.',$row['iq_img'.$u]);
									
									if($f_ex[1] == "mp4"){
										// 비디오 플레이어 출력
										echo "<video style='padding-left:5px;padding-right:5px;max-width:20% !important;' controls>
												<source src='".$it_img_urls."' type='video/mp4'>
											  </video>";
									} else {
										// 이미지 출력
										echo "<img src='".$it_img_urls."' style='padding-left:5px;padding-right:5px;max-width:20% !important;'>";
									}
								}
							}
						?>
                    </div>
					<?php if ($is_admin || ($row['mb_id'] == $member['mb_id'] && !$is_answer)) { ?>
					<div class="sit_qa_cmd">
						<a href="<?php echo $itemqa_form."&amp;iq_id={$row['iq_id']}&amp;w=u"; ?>" class="itemqa_form _btn/small/gray" onclick="return false;">수정</a>
						<a href="<?php echo $itemqa_formupdate."&amp;iq_id={$row['iq_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemqa_delete _btn/small/gray/line/transparent">삭제</a>
					</div>
					<?php } ?>
                    <?php if(!$is_secret) { ?>
                    <div class="sit_qa_qaa">
                        <strong class="sound_only">답변</strong>
                        <span class="qa_alp">A</span>
                        <?php echo $iq_answer; ?>
                    </div>
                    <?php } ?>
                </div>

                
            </div>
        </li>

    <?php
        $iq_num--;
    }

    if ($i > 0) echo '</ol>';

    if (!$i) echo '<p class="sit_empty">상품문의가 없습니다.</p>';
    ?>
</section>

<?php
echo itemqa_page($config['cf_write_pages'], $page, $total_page, G5_SHOP_URL."/itemqa.php?it_id=$it_id&amp;page=", "");
?>

<script>
$(function(){
    $(".itemqa_form").click(function(){
        window.open(this.href, "itemqa_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".itemqa_delete").click(function(){
        return confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.");
    });

    $(".sit_qa_li_title").click(function(){
        var $con = $(this).siblings(".sit_qa_con");
        if($con.is(":visible")) {
            $con.slideUp();
        } else {
            $(".sit_qa_con:visible").hide();
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
        }
    });

    $(".qa_page").click(function(){
        $("#itemqa").load($(this).attr("href"));
        return false;
    });
});
</script>
<!-- } 상품문의 목록 끝 -->