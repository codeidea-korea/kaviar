<?php
// 공동으로 사용하기 위해 파일 생성 - 인태 수정
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$btnName = $btnName ? $btnName : '댓글달기';
$cmt_img_width = 400; // 썸네일 가로사이즈 설정
$bo_comment_popup = G5_IS_MOBILE ? true : false;
?>
<script>
// 글자수 제한
var char_min = parseInt(<?php echo $comment_min ?>); // 최소
var char_max = parseInt(<?php echo $comment_max ?>); // 최대
</script>

<section id="bo_view_comment">
	
	<!--<div class="viewReply_btnSet"><a href="#writeReply_pop" id="btn" onclick="comment_box('', 'c');" class="popup-reply-form btnReply"><?=$btnName?></a></div>-->

	

	<?php if($bo_comment_popup) echo '<div class="add-comment"><a href="#bo_vc_w" class="btn-pop-comment" data-comment-id="" data-w="c" alt="댓글 추가하기">댓글 추가하기...</a></div>'; ?>

	<?php //if(number_format($view['wr_comment']) < 1)  {
		include($board_skin_path.'/view_comment_form.php');
	//} ?>

	<?php
	$cmt_amt = count($list);
	for ($i=0; $i<$cmt_amt; $i++) {
		$comment_id = $list[$i]['wr_id'];
		$cmt_depth = strlen($list[$i]['wr_comment_reply']) * 25;
		$comment = $list[$i]['content'];
		$article_re = $cmt_depth ? 're' : '';
		$replyCon_secret =  strstr($list[$i]['wr_option'], "secret") ? 'secret' : '';
		if(strstr($list[$i]['wr_option'], "secret")) $str = $str;
		
		$comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);
		$cmt_sv = $cmt_amt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
	 ?>

	<article id="c_<?php echo $comment_id ?>" class="listCo <?=$article_re?>" style="<?php if($cmt_depth) echo 'margin-left:'.$cmt_depth.'px;';?>">

		<div class="co-head" style="z-index:<?php echo $cmt_sv; ?>">
			<span class="writer"><?=get_mb_img($list[$i]['mb_id'], 25, 25, false)?><?php echo $list[$i]['name'] ?></span>
			<?php if($is_admin && $board['bo_use_reply_phone']) echo '<span class="tel">'.$list[$i]['wr_1'].'</span>'; ?>
			<span class="date mont"><time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', strtotime($list[$i]['datetime'])) ?>"><?=passing_time($list[$i]['datetime'])?></time></span>
			<?php include(G5_SNS_PATH.'/view_comment_list.sns.skin.php'); ?>
		</div>

		<div class="replyCon-wrap">
			<span class="replyCon"><?php echo htmlspecialchars_decode($comment)?></span>
			<?php if($list[$i]['is_reply']) {
			if($bo_comment_popup) {
					//echo '<a href="#bo_vc_w" class="btn-pop-comment" data-comment-id="'.$comment_id.'" data-w="c" class="co_re" alt="답변">답변</a>';
				} else {
					//echo '<a href="'.$c_reply_href.'" onclick="comment_box('.$comment_id.', \'c\'); return false;" class="co_re" alt="답변">답변</a>';
				}
			} ?>
		</div>
		

		<span id="edit_<?=$comment_id?>" class="area_form"></span>
		<span id="reply_<?=$comment_id?>" class="area_form"></span>

		<!-- 댓글 첨부파일 -->
		<input type="hidden" value="<?php echo $list[$i]['wr_file'] ?>" id="wr_file_comment_<?php echo $comment_id ?>">
		<input type="hidden" value="<?php echo $file[0]['source'] ?>" id="wr_filesource_comment_<?php echo $comment_id ?>">
		<!-- //댓글 첨부파일 -->
		<input type="hidden" value="<?=strstr($list[$i]['wr_option'],"secret")?>" id="secret_comment_<?=$comment_id?>">
		<textarea id="save_comment_<?=$comment_id?>" style="display:none"><?=get_text($list[$i]['content1'], 0)?></textarea>
		
		<?php if($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del']) {
			$query_string = str_replace("&", "&amp;", $_SERVER['QUERY_STRING']);
			if($w == 'cu') {
				$sql = " select wr_id, wr_content from $write_table where wr_id = '$c_id' and wr_is_comment = '1' ";
				$cmt = sql_fetch($sql);
				if (!($is_admin || ($member['mb_id'] == $cmt['mb_id'] && $cmt['mb_id'])))
					$cmt['wr_content'] = '';
				$c_wr_content = $cmt['wr_content'];
			}
			
		 ?>

		<div class="co_btnSet">
			<ul>
				<?php
				if($bo_comment_popup) {
					if($list[$i]['is_edit']) echo '<li><a href="#bo_vc_w" class="btn-pop-comment" data-comment-id="'.$comment_id.'" data-w="cu" class="co_edit" alt="수정">수정</a></li>';
				} else {
					if($list[$i]['is_edit']) echo '<li><a href="'.$c_edit_href.'" onclick="comment_box('.$comment_id.', \'cu\'); return false;" class="co_edit" alt="수정">수정</a></li>';
				}
				if($list[$i]['is_del']) echo '<li><a href="'.$list[$i]['del_link'].'" onclick="return comment_delete();" class="co_del" alt="삭제">삭제</a></li>';
				/*if($bo_comment_popup) {
					if($list[$i]['is_reply']) echo '<li><a href="#bo_vc_w" class="btn-pop-comment" data-comment-id="'.$comment_id.'" data-w="c" class="co_re" alt="답변">답변</a></li>';
				} else {
					if($list[$i]['is_reply']) echo '<li><a href="'.$c_reply_href.'" onclick="comment_box('.$comment_id.', \'c\'); return false;" class="co_re" alt="답변">답변</a></li>';
				}*/
				?>
			</ul>
		</div>
		<?php } ?>

	</article>
	<?php } ?>
	<?php if ($i == 0) { ?><p id="bo_vc_empty">등록된 답변 없습니다.</p><?php } ?>

</section>

<script>
<?php if($bo_comment_popup) { ?>
$(".btn-pop-comment").click(function(){
	var co_id = $(this).data('comment-id');
	var w = $(this).data('w');
	comment_box(co_id, w);
	if(co_id && w == 'c') {
		$('.popCon_head').empty();
		var re_id = $('#c_' + co_id),
			re_id_header = re_id.find('header').clone(),
			re_id_con = re_id.find('.replyCon').clone();
		re_id_header.appendTo('.popCon_head');
		re_id_con.appendTo('.popCon_head');
		//$('.popCon_head').html(re_id_header, re_id_con);
	} else {
		var popCon_head = '<div class="popCon_title"><?=strip_tags($view["wr_subject"])?></div>';
		<?php if($view['wr_short_con']) { ?>
		popCon_head += '<div class="popCon_shortCon"><?=nl2br($view["wr_short_con"])?></div>';
		<?php } ?>
		$('.popCon_head').html(popCon_head);
	}
	$('.reform_btnSet').html('<span class="btn_cancel popClose">취소</span><input type="submit" id="btn_submit" value="등록하기" class="btn_submit">');
});
$(document).ready(function() {
	$('.btn-pop-comment').magnificPopup({
		type: 'inline',
		fixedContentPos: false,
		fixedBgPos: true,
		closeOnContentClick: false, 
        closeOnBgClick: false,
		overflowY: 'auto',
		closeBtnInside: true,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
});
<?php } ?>
</script>

<?php if($is_comment_write) { ?>
<script>
var save_before = '';
var save_html = document.getElementById('bo_vc_w').innerHTML;

function good_and_write() {
    var f = document.fviewcomment;
    if (fviewcomment_submit(f)) {
        f.is_good.value = 1;
        f.submit();
    } else {
        f.is_good.value = 0;
    }
}

function fviewcomment_submit(f) {
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    f.is_good.value = 0;

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": "",
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        f.wr_content.focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    if (char_min > 0 || char_max > 0) {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt) {
            alert("댓글은 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt) {
            alert("댓글은 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    } else if (!document.getElementById('wr_content').value) {
        alert("댓글을 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined') {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '') {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined') {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '') {
            alert('비밀번호가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    set_comment_token(f);

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

function comment_box(comment_id, work) {
    var el_id,
        form_el = 'fviewcomment',
        respond = document.getElementById(form_el);

	//취소버튼 추가
	$('.form-list.wr_content .btnClose').remove();
	if (comment_id) {
		<?php if(G5_IS_MOBILE) { ?>
		$('.area_form .reply-toggle').hide();
		$('.area_form ._comment_form').show();
		<?php } else { ?>
		$('.form-list #wr_content').after('<a href="javascript:comment_box(\'\', \'c\');" class="btnClose" alt="취소">취소</a>');
		<?php } ?>
	}

    // 댓글 아이디가 넘어오면 답변, 수정
    if (comment_id) {
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    } else {
        el_id = 'bo_vc_w';
		<?php if(G5_IS_MOBILE) { ?>
		$('.area_form .reply-toggle').show();
		$('.area_form ._comment_form').hide();
		<?php } ?>
	}

    if (save_before != el_id) {		
		<?php if(!$bo_comment_popup) { ?>
        if (save_before) {
            document.getElementById(save_before).style.display = 'none';
        }
        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).appendChild(respond);
		<?php } ?>
        //입력값 초기화
        document.getElementById('wr_content').value = '';
       
        // 댓글 수정
        if (work == 'cu') {
            document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
			//document.getElementById('wr_1').value = document.getElementById('save_wr1_' + comment_id).value; //
            if (typeof char_count != 'undefined')
                check_byte('wr_content', 'char_count');
			<?php if($board['bo_reply_secret']) { ?>
            if (document.getElementById('secret_comment_'+comment_id).value)
                document.getElementById('wr_secret').checked = true;
            else
                document.getElementById('wr_secret').checked = false;
			<?php } ?>
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;

        if(save_before)
            $("#captcha_reload").trigger("click");

        save_before = el_id;
    }
}

function comment_delete() {
    <?php if($is_guest) echo 'return'; else echo 'return confirm("이 댓글을 삭제하시겠습니까?");'; ?>
}

comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>
// sns 등록
$(function() {
    $("#bo_vc_send_sns").load(
        "<?php echo G5_SNS_URL; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>",
        function() {
            save_html = document.getElementById('bo_vc_w').innerHTML;
        }
    );
});
<?php } ?>
</script>
<?php } ?>