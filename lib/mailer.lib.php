<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_PHPMAILER_PATH.'/PHPMailerAutoload.php');

// 메일 보내기 (파일 여러개 첨부 가능)
// type : text=0, html=1, text+html=2
function mailer($fname, $fmail, $to, $subject, $content, $type=0, $file="", $cc="", $bcc="")
{
    global $config;
    global $g5;

    // 메일발송 사용을 하지 않는다면
    if (!$config['cf_email_use']) return;

    if ($type != 1)
        $content = nl2br($content);

    $result = run_replace('mailer', $fname, $fmail, $to, $subject, $content, $type, $file, $cc, $bcc);
    
    if( is_array($result) && isset($result['return']) ){
        return $result['return'];
    }

    $mail_send_result = false;
    
    try {
        $mail = new PHPMailer(); // defaults to using php "mail()"
        if (defined('G5_SMTP') && G5_SMTP) {
            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->Host = G5_SMTP; // SMTP server
            if(defined('G5_SMTP_PORT') && G5_SMTP_PORT)
                $mail->Port = G5_SMTP_PORT;
        }
        
        
        //////
//         $mail->Host = "smtps.hiworks.com";
//         $mail->Port = "587";
//         $mail->Username = "kaviarmall@kaviar.kr";
//         $mail->Password = "IsfRtAqGhZaeHkrdPpFE";
//         $mail->AuthType = "LOGIN";
//         $mail->SMTPSecure = "TLS";
//         $mail->SMTPAuth = true;
        //////
        
        //hiworks.com 호스트설정
        if (defined('G5_SMTP_HIWORKS_HOST') && G5_SMTP_HIWORKS_HOST) {
        	$mail->IsSMTP(); 
        	$mail->Host = G5_SMTP_HIWORKS_HOST;
        	
        	//port 설정
        	if(defined('G5_SMTP_HIWORKS_PORT') && G5_SMTP_HIWORKS_PORT)
        		$mail->Port = G5_SMTP_HIWORKS_PORT;
        	// username 설정
        	if(defined('G5_SMTP_HIWORKS_USERNAME') && G5_SMTP_HIWORKS_USERNAME)
        		$mail->Username = G5_SMTP_HIWORKS_USERNAME;
        	
        	// password 설정
        	if(defined('G5_SMTP_HIWORKS_PASSWORD') && G5_SMTP_HIWORKS_PASSWORD)
        		$mail->Password = G5_SMTP_HIWORKS_PASSWORD;
        	
       		// AuthType 설정
        	if(defined('G5_SMTP_HIWORKS_AUTHTYPE') && G5_SMTP_HIWORKS_AUTHTYPE)
        		$mail->AuthType = G5_SMTP_HIWORKS_AUTHTYPE;
        	
        	// SMTPSecure 설정
        	if(defined('G5_SMTP_HIWORKS_SMTPSECURE') && G5_SMTP_HIWORKS_SMTPSECURE)
        		$mail->SMTPSecure = G5_SMTP_HIWORKS_SMTPSECURE;
			
			// SMTPAuth 설정
			if(defined('G5_SMTP_HIWORKS_SMTPAUTH') && G5_SMTP_HIWORKS_SMTPAUTH)
				$mail->SMTPAuth = G5_SMTP_HIWORKS_SMTPAUTH;
        }

        $mail->CharSet = 'UTF-8';
        $mail->From = $fmail;
        $mail->FromName = $fname;
        $mail->Subject = $subject;
        $mail->AltBody = ""; // optional, comment out and test
        $mail->msgHTML($content);
        $mail->addAddress($to);
        if ($cc)
            $mail->addCC($cc);
        if ($bcc)
            $mail->addBCC($bcc);
        //print_r2($file); exit;
        if ($file != "") {
            foreach ($file as $f) {
                $mail->addAttachment($f['path'], $f['name']);
            }
        }

    $mail = run_replace('mail_options', $mail, $fname, $fmail, $to, $subject, $content, $type, $file, $cc, $bcc);


        $mail_send_result = $mail->send();

    } catch (Exception $e) {
    }

    run_event('mail_send_result', $mail_send_result, $mail, $to, $cc, $bcc);

    return $mail_send_result;
}

// 파일을 첨부함
function attach_file($filename, $tmp_name)
{
    // 서버에 업로드 되는 파일은 확장자를 주지 않는다. (보안 취약점)
    $dest_file = G5_DATA_PATH.'/tmp/'.str_replace('/', '_', $tmp_name);
    move_uploaded_file($tmp_name, $dest_file);
    $tmpfile = array("name" => $filename, "path" => $dest_file);
    return $tmpfile;
}