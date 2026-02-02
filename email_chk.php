<?php
include_once('./_common.php');

// 네이버 로그인 설정
$client_id = "X7ipw6oMsgFH0i7lbmA0";
$client_secret = "8qKY3GMbi7";
$redirect_uri = "https://kaviar.co.kr/plugin/social/?hauth.done=naver";

// 네이버 재인증 URL 생성 (auth_type=reprompt 추가)
$state = md5(rand());
$_SESSION['state'] = $state;

$naver_auth_url = "https://nid.naver.com/oauth2.0/authorize?response_type=code";
$naver_auth_url .= "&client_id=".$client_id;
$naver_auth_url .= "&redirect_uri=".urlencode($redirect_uri);
$naver_auth_url .= "&state=".$state;
$naver_auth_url .= "&auth_type=reprompt"; // 재동의 요청
$naver_auth_url .= "&scope=email"; // 이메일 권한 특정

// 동의 화면 템플릿
$g5['title'] = "네이버 계정 추가 권한 동의";
include_once('./_head.php');
?>

<div class="mbskin">
    <div class="alert alert-info">
        <strong>추가 권한 동의가 필요합니다</strong>
        <p>서비스 이용을 위해 이메일 주소 접근 권한이 필요합니다.</p>
    </div>

    <div class="auth_request">
        <h3>요청 권한</h3>
        <ul>
            <li>
                <strong>이메일 주소</strong>
                <p>회원님의 이메일 주소를 받아 서비스에 활용합니다.</p>
            </li>
        </ul>
    </div>
    
    <div class="btn_confirm">
        <a href="<?php echo $naver_auth_url ?>" class="btn_submit">추가 권한 동의하기</a>
        <a href="<?php echo G5_URL ?>" class="btn_cancel">취소</a>
    </div>
</div>

<style>
.mbskin { max-width: 600px; margin: 30px auto; padding: 20px; }
.alert-info { background: #f8f9fa; border: 1px solid #dee2e6; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
.auth_request { margin: 20px 0; }
.auth_request ul { list-style: none; padding: 0; }
.auth_request li { margin: 10px 0; padding: 10px; border: 1px solid #eee; border-radius: 4px; }
.btn_confirm { margin-top: 30px; text-align: center; }
.btn_submit, .btn_cancel { display: inline-block; padding: 10px 20px; margin: 0 5px; }
.btn_submit { background: #03C75A; color: #fff; border-radius: 4px; text-decoration: none; }
.btn_cancel { background: #f1f3f5; color: #333; border-radius: 4px; text-decoration: none; }
</style>

<?php
include_once('./_tail.php');
?>