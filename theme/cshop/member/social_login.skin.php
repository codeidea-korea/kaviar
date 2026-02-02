<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if( ! $config['cf_social_login_use']) {     //소셜 로그인을 사용하지 않으면
    return;
}

$social_pop_once = false;

$self_url = G5_BBS_URL."/login.php";

//새창을 사용한다면
if( G5_SOCIAL_USE_POPUP ) {
    $self_url = G5_SOCIAL_LOGIN_URL.'/popup.php';
}
?>

<div id="sns_login">
    <h3>SNS계정으로 간편하게 회원가입</h3>
    <div class="snsContainer">
        <?php
		if( social_service_check('kakao') ) echo '<a href="'.$self_url.'?provider=kakao&amp;url='.$urlencode.'" class="_sns_kakao" title="카카오">카카오 로그인</a>';
		if( social_service_check('naver') ) echo '<a href="'.$self_url.'?provider=naver&amp;url='.$urlencode.'" class="_sns_naver" title="네이버">네이버 로그인</span></a>';		
        if( social_service_check('facebook') ) echo '<a href="'.$self_url.'?provider=facebook&amp;url='.$urlencode.'" class="_sns_facebook" title="페이스북">페이스북 로그인</a>';
        if( social_service_check('google') ) echo '<a href="'.$self_url.'?provider=google&amp;url='.$urlencode.'" class="_sns_google" title="구글">구글 로그인</a>';
		if( social_service_check('twitter') ) echo '<a href="'.$self_url.'?provider=twitter&amp;url='.$urlencode.'" class="_sns_twitter" title="트위터">트위터 로그인</a>';
        if( social_service_check('payco') ) echo '<a href="'.$self_url.'?provider=payco&amp;url='.$urlencode.'" class="_sns_payco" title="페이코">페이코 로그인</a>';

        if( G5_SOCIAL_USE_POPUP && !$social_pop_once ){
        $social_pop_once = true;
        ?>
        <script>
            jQuery(function($){
                $(".snsContainer").on("click", "a", function(e){
                    e.preventDefault();

                    var pop_url = $(this).attr("href");
                    var newWin = window.open(
                        pop_url, 
                        "social_sing_on", 
                        "location=0,status=0,scrollbars=1,width=600,height=500"
                    );

                    if(!newWin || newWin.closed || typeof newWin.closed=='undefined')
                         alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');

                    return false;
                });
            });
        </script>
        <?php } ?>

    </div>
</div>