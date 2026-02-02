<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div id="myitemqa_view">
	
	<?php for ($i=0; $row=sql_fetch_array($result); $i++) {
		$row2 = get_shop_item($row['it_id'], true);
		$it_href = shop_item_url($row['it_id']);
		$iq_subject = conv_subject($row['iq_subject'],50,"…");
		$iq_time = substr($row['iq_time'], 0, 10);
		$iq_time = str_replace("-", ".", $iq_time);
		$iq_question[$i] = '<div class="ic_q">'.strip_tags($row['iq_question'],"<p>").'</div>';
		preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $row['iq_question'], $match);
		$iq_question_thumb[$i] = $match[0];
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
	?>
	
	<div class="qa_v_item_li">
		<div class="inner">
			<div class="thumb">
				<a href="<?=$it_href?>"><?=get_it_image($row['it_id'], 100, 100)?></a>
			</div>
			<div class="con">
				<div class="it_name"><a href="<?=$it_href?>"><?=$row2['it_name']?></a></div>		
				<div class="flex flex-middle gap10">
					<div class="middleline price"><?=display_price($row2['it_cust_price'])?></div>
					<div class="color-red bold price"><?=display_price($row2['it_price'])?></div>
				</div>
			</div>
		</div>
	</div>

	<div class="iq_question">
		<div class="head">
			<span class="subject"><?=$iq_subject?></span>
			<span class="date"><?=$iq_time?></span>
		</div>
		<?=$iq_question[$i].$iq_question_thumb[$i]?>
		<br>
		<div style="display:flex;flex-direction: column;">
		<?
		for($i=1; $i<=5; $i++) {
			$it_img_urls = G5_URL."/data/shop_qa/".$row['iq_img'.$i];
			
			if($row['iq_img'.$i] != ''){
				
				$f_ex = explode('.',$row['iq_img'.$i]);

				if($f_ex[1] == "mp4"){
					// 비디오 플레이어 출력
					echo "<video style='width:40%' controls>
							<source src='".$it_img_urls."' type='video/mp4'>
						  </video>";
				} else {
					// 이미지 출력
					echo "<img src='".$it_img_urls."' style='width:25%'>";
				}		
			}
		}
		?>
		<div>	
	</div>
	<div class="con" style="margin-top:20px;border-top:1px solid #e7e7e7;display:flex;">
		<div style="font-weight:bold;padding-top:10px;">
			답변 : 
		</div>
		<div style="pading-left:10xp;padding-top:10px;">
			<?=$iq_answer?>
		</div>
	</div>
<!--					
	<div class="qa_li_answer" style="padding-top:20pox;padding-bottom:15px">
		
		<?=$iq_answer?>

		<div class="sit_qa_cmd">
			<a href="<?php echo $itemqa_form."&amp;iq_id={$row['iq_id']}&amp;w=u"; ?>" class="pop-modal-qa _btn/sm/rd5/gray" onclick="return false;">수정</a>
			<a href="<?php echo $itemqa_formupdate."&amp;iq_id={$row['iq_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemqa_delete _btn/sm/rd5/gray/line/transparent">삭제</a>
		</div>
	</div>


	<?php if ($row['iq_answer']) {
		echo '<div class="iq_answer">'.$iq_answer[$i].$iq_answer_thumb[$i].'</div>';
	} ?>
-->	
	<?php } ?>

</div>