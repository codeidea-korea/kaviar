<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH') && file_exists(G5_THEME_PATH."/mobile/tail.php")) {
    //require_once(G5_THEME_PATH.'/tail.php');
    //return;
}
?>
    </div>
		
		<footer id="footer" class="footer <?=$footer['ft_inc']?'inc':''?> <?=$footer['color_reverse']?'reverse':''?>" style="<?php if(!$footer['ft_inc'] && $footer['background']) echo 'background:'.$footer['background'].';';?><?php if(!$footer['ft_inc'] && $footer['color_reverse']) echo 'color:#fff;';?>">
			<?php if($footer['ft_inc']) {
				$is_footer = file_exists(G5_THIS_PATH.'/footer.php');
				if($is_footer) include_once(G5_THIS_PATH.'/footer.php');
				$footerOn = $is_footer ? 'htmlOn' : '';
			} else {
				echo '<div class="footer-container">';
				if($footer['copyright']) echo '<div class="copyright">'.$footer['copyright'].'</div>';
				echo '</div>';
			} ?>
			<div id="footer-iconSet">
				<?php if($is_admin == 'super' && defined("_INDEX_")){ echo '<span class="icon_includeInfo '.$footerOn.'" data-tip="popup/html/footer.php"><span></span></span>'; }?>
				<?php
				//if ($adminIP && !$is_member) {
				if (!$is_member) {
					if($config['cf_use_login_popup']) {
						echo '<a href="'.G5_BBS_URL.'/ajax.login.php" class="icon_login popup-ajax" data-tip="로그인" alt="로그인">로그인<span></span></a>';
					} else {
						echo '<a href="'.G5_BBS_URL.'/login.php" class="icon_login" data-tip="로그인" alt="로그인">로그인<span></span></a>';
					}
				}?>					
			</div>
			
		</footer>

	</div>

</div>

<?php include_once(G5_BBS_PATH.'/my/pop-hd-search-set.php'); //사이트 검색(일반 팝업) ?>

<div class="mobile-max-width flex flex-right px10">
	<button type="button" id="_gototop" class="hidden"><span class="sound_only">상단으로</span></button>
</div>
<script>
$(window).scroll(function() {
	if( $(this).scrollTop() >= 1200 ) {
		$("#_gototop").removeClass('hidden');
	} else {
		$("#_gototop").addClass('hidden');
	}
});
$(function() {
	$("#_gototop").on("click", function() {
		$("html, body").animate({scrollTop:0}, '500');
		return false;
	});
});
</script>

<script>
jQuery(function($) {

    $( document ).ready( function() {

        // 폰트 리사이즈 쿠키있으면 실행
        font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
        
        //상단고정
        if( $(".top").length ){
            var jbOffset = $(".top").offset();
            $( window ).scroll( function() {
                if ( $( document ).scrollTop() > jbOffset.top ) {
                    $( '.top' ).addClass( 'fixed' );
                }
                else {
                    $( '.top' ).removeClass( 'fixed' );
                }
            });
        }

        //상단으로
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });

    });
});

//상단고정
/*$( document ).ready( function() {
    var jbOffset = $( '.top' ).offset();
    $( window ).scroll( function() {
        if ( $( document ).scrollTop() > jbOffset.top ) {
            $( '.top' ).addClass( 'fixed' );
        }
        else {
            $( '.top' ).removeClass( 'fixed' );
        }
    });
});*/
//상단으로
$(function() {
    $("#top_btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});
</script>

<?php
if($myStyle) echo '<style name="myStyle">'.$myStyle.'</style>'.PHP_EOL;
if($myScript) echo '<script name="myScript">'.$myScript.'</script>'.PHP_EOL;

// ─────────────────────────────────────────────────────────────────────
if($is_includers) include_once(G5_BBS_PATH.'/my/_includers_mobile.php'); //참조 파일 리스트 출력
// ─────────────────────────────────────────────────────────────────────

include_once(G5_PATH."/tail.sub.php");