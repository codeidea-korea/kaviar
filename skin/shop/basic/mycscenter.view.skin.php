<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div id="_mycscenter_view">

    <div class="subject">
		<?=$view['wr_subject']?>
	</div>
	<div class="con">
		<?=$view['wr_content']?>
	</div>
	<div class="con" style="display:flex;flex-direction: column;">
		<?
			$img_chk = sql_fetch(" select group_concat(bf_file) as bf_file from `g5_board_file` where bo_table = '11_inquiry' and  wr_id= '".$view['wr_id']."' ");
			$files = explode(",",$img_chk['bf_file']);
			$dirfile = G5_URL.'/data/file/11_inquiry/';
			for($i=0; $i< count($files); $i++) {
				
				$f_ex = explode('.',$files[$i]);

				if($f_ex[1] == "mp4"){
					// 비디오 플레이어 출력
					echo "<video style='width:25%;padding-top:5px;padding-bottom:5px' controls>
							<source src='".$dirfile.$files[$i]."' type='video/mp4'>
						  </video>";
				} else {
					// 이미지 출력
					echo "<img src='".$dirfile.$files[$i]."' style='width:25%;padding-top:5px;padding-bottom:5px'>";
				}
			}
			
		?>
	</div>

	<?php
	$sql = " select * from $tmp_write_table where wr_parent = '$wr_id' and wr_is_comment = 1 order by wr_comment, wr_comment_reply ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = $row;

		//$list[$i]['name'] = get_sideview($row['mb_id'], cut_str($row['wr_name'], 20, ''), $row['wr_email'], $row['wr_homepage']);

		$tmp_name = get_text(cut_str($row['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
		$list[$i]['name'] = '<span class="'.($row['mb_id']?'member':'guest').'">'.$tmp_name.'</span>';
		$list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');
		$list[$i]['datetime'] = substr($row['wr_datetime'],2,14);

	}
	?>
	<?php
	$cmt_amt = count($list);
	for ($i=0; $i<$cmt_amt; $i++) {
		$comment_id = $list[$i]['wr_id'];
		$cmt_depth = strlen($list[$i]['wr_comment_reply']) * 25;
		$comment = $list[$i]['content'];		
		$comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);

		$comment1 = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $list[$i]['wr_content']);

		
		echo '<article class="listCo">';
			echo '<div class="co-head">';
				echo '<span class="writer">'.$list[$i]['name'].'</span>';
				echo '<span class="date mont"><time datetime="'.date('Y-m-d\TH:i:s+09:00', strtotime($list[$i]['datetime'])).'">'.passing_time($list[$i]['datetime']).'</time></span>';
			echo '</div>';

			echo '<div class="replyCon-wrap">';
				echo '<pre style="white-space: pre-wrap;"><span class="replyCon">'.$comment1.'</span></pre>';
			echo '</div>';
		echo '</article>';
	} ?>

	<div class="mt50 tcenter">
		<a href="<?=shop_short_url_my('mycscenter')?>" class="_btn/lg/line/transparent historyback">뒤로가기</a>
	</div>

</div>