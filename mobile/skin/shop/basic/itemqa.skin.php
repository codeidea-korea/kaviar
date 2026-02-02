<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div class="v_header px15">
	<div class="title">상품문의 <span class="count">(<?=$total_count?>)</span></div>
	<a href="<?=$itemqa_form?>" class="pop-modal-qa _btn/rd5/sm/mainColor ic-arrow-right ml-auto">문의 작성하기</a>
</div>

<!--<div id="sit_qa_wbtn">
    <a href="<?php echo $itemqa_form; ?>" class="itemqa_form qa_wr">상품문의 쓰기<span class="sound_only"> 새 창</span></a>
    <a href="<?php echo $itemqa_list; ?>" id="itemqa_list" class="btn01">더보기</a>
</div>-->

<div id="v_qa_list">

    <?php
    $thumbnail_width = 500;
    $iq_num = $total_count - ($page - 1) * $rows;

    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $iq_name    = get_text($row['iq_name']);
        $iq_subject = conv_subject($row['iq_subject'],50,"…");

		$iq_question[$i] = preg_replace("/<(.*?)\>/"," ",$row['iq_question']); 
		$iq_question[$i] = preg_replace("/&nbsp;/"," ",$iq_question[$i]); 
		$iq_question[$i] = str_replace("//##", " ", $iq_question[$i]);
		$iq_question[$i] = cut_str($iq_question[$i], 200, '…');
		preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $iq_question, $match);
		$iq_question_thumb[$i] = $match[0];

        $is_secret = false;
        if($row['iq_secret']) {
            //$iq_subject .= ' <img src="'.G5_MSHOP_SKIN_URL.'/img/icon_secret.gif" alt="비밀글">';

            if($is_admin || $member['mb_id' ] == $row['mb_id']) {
                //$iq_question = '<div class="ic_q">'.get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width).'</div>';
				$iq_question[$i] = '<div class="ic_q">'.$iq_question[$i].'</div>';
            } else {
                $iq_question[$i] = '<div class="ic_secret">비밀글입니다.</div>';
                $is_secret = true;
            }
        } else {
            $iq_question[$i] = '<div class="ic_q">'.$iq_question[$i].'</div>';
        }
        $iq_time    = substr($row['iq_time'], 2, 8);

        $hash = md5($row['iq_id'].$row['iq_time'].$row['iq_ip']);

        $iq_stats = '';
        //$iq_style = '';
        $iq_answer = '';

        if ($row['iq_answer']) {
            $iq_answer = get_view_thumbnail(conv_content($row['iq_answer'], 1), $thumbnail_width);

			//황팀 임시 추가.. ------------------------------------------
			$answerCon[$i] = preg_replace("/<(.*?)\>/"," ",$iq_answer); 
			$answerCon[$i] = preg_replace("/&nbsp;/"," ",$answerCon[$i]); 
			$answerCon[$i] = str_replace("//##", " ", $answerCon[$i]);
			$answerCon[$i] = cut_str($answerCon[$i], 200, '…');
			preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $iq_answer, $match);
			$answer_thumb[$i] = $match[0];
			// --------------------------------------------------------

            $iq_stats = '<span class="tag complete">답변완료</span>';
            //$iq_style = 'sit_qaa_done';
            $is_answer = true;
        } else {
            $iq_stats = '<span class="tag">답변대기</span>';
            //$iq_style = 'sit_qaa_yet';
            $iq_answer = '답변이 등록되지 않았습니다.';
            $is_answer = false;
        }

        if ($i == 0) echo '<ul>';
    ?>

        <li id="qa_li_<?=$i?>" class="qa_list">
			<div class="inner">
				<div class="qa_list_header <?=$is_secret?'':'qa-toggle'?>" data-target="#qa_li_<?=$i?>">
					<div class="top">
						<span class="qaCate"><?=$iq_subject?></span>
						<div class="writer"><?=$is_admin ? $iq_name : mb_substr($iq_name,0,-2)."**"?></div>
						<div class="date"><?=$iq_time?></div>
					</div>
					<div class="qa_li_question"><?=$iq_question[$i]?></div>
				</div>
				<?php if(!$is_secret) { ?>
				<div class="qa_li_answer1">
					<div style="display:flex;align-items:center;padding-left:20px;">
					<?
					for($i=1; $i<=5; $i++) {
						$it_img_urls = G5_URL."/data/shop_qa/".$row['iq_img'.$i];
						
						if($row['iq_img'.$i] != ''){
							
							$f_ex = explode('.',$row['iq_img'.$i]);

							if($f_ex[1] == "mp4"){
								// 비디오 플레이어 출력
								echo "<video style='width:30%;padding-left:3px;padding-right:3px' controls>
										<source src='".$it_img_urls."' type='video/mp4'>
									  </video>";
							} else {
								// 이미지 출력
								echo "<img src='".$it_img_urls."' style='width:15%;padding-left:3px;padding-right:3px'>";
							}		
						}
					}
					?>
					</div>
				</div>
				<div class="qa_li_answer">
					
							
					<?=$iq_answer?>
					<?=$answerCon[$i]?>
					<?php if($answer_thumb[$i]) echo '<div class="thumb">'.$answer_thumb[$i].'</div>'; ?>
					<?php if ($is_admin || ($row['mb_id'] == $member['mb_id'] && !$is_answer)) { ?>
					<div class="sit_qa_cmd">
						<a href="<?php echo $itemqa_form."&amp;iq_id={$row['iq_id']}&amp;w=u"; ?>" class="pop-modal-qa _btn/sm/rd5/gray" onclick="return false;">수정</a>
						<a href="<?php echo $itemqa_formupdate."&amp;iq_id={$row['iq_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemqa_delete _btn/sm/rd5/gray/line/transparent">삭제</a>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<div class="iq_stats"><?=$iq_stats?></div>
        </li>

    <?php
        $iq_num--;
    }

    if ($i > 0) echo '</ul>';

    if (!$i) echo '<p class="sit_empty">상품문의가 없습니다.</p>';
    ?>
</div>

<?php
echo itemqa_page($config['cf_mobile_pages'], $page, $total_page, G5_SHOP_URL."/itemqa.php?it_id=$it_id&amp;page=", "");
?>

<script>
//magnific-popup
$('.pop-modal-qa').magnificPopup({
	type: 'ajax',
	fixedContentPos: true,
	fixedBgPos: true,
	closeOnContentClick: false, 
	closeOnBgClick: false,
	overflowY: 'auto',
	closeBtnInside: true,
});
$(document).on('click', '.modalClose', function (e) {
	e.preventDefault();
	$.magnificPopup.close();
});

//문의 토글
$(".qa-toggle").click(function() {
	var target = $(this).attr('data-target');
	$(target).toggleClass('open');
});



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
        //$("#itemqa").load($(this).attr("href"));
		$("#v_qna").load($(this).attr("href"));
        return false;
    });

    $("a#itemqa_list").on("click", function() {
        window.opener.location.href = this.href;
        self.close();
        return false;
    });
});
</script>