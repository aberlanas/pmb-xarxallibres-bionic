<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: mail.inc.php,v 1.31 2016-04-29 08:32:56 dbellamy Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

require_once($class_path.'/class.phpmailer.php') ;
require_once($class_path.'/class.smtp.php') ;

if (!defined('PHP_EOL')) define ('PHP_EOL', strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");

function mailpmb($to_nom="", $to_mail, $obj="", $corps="", $from_name="", $from_mail, $headers, $copie_CC="", $copie_BCC="", $faire_nl2br=0, $pieces_jointes=array()) {

	global $pmb_mail_methode,$pmb_mail_html_format,$pmb_mail_adresse_from;
	global $charset;
	
	if (!is_array($pieces_jointes)) {
		$pieces_jointes=array();
	}
	
	$param = explode(",",$pmb_mail_methode) ;
	if (!$param) {
		$param=array() ;
	}

	$mail = new PHPMailer();
	//$mail->SMTPDebug=1;
	$mail->CharSet = $charset;
	$mail->SMTPAutoTLS=false;

	if ($copie_CC) {
		$destinataires_CC = explode(";",$copie_CC) ;
	} else {
		$destinataires_CC = array();
	}
	if ($copie_BCC) {
		$destinataires_BCC = explode(";",$copie_BCC) ;
	} else {
		$destinataires_BCC = array();
	}
	$destinataires = explode(";",$to_mail) ;

	switch ($param[0]) {
		case 'smtp':
			// $pmb_mail_methode = m�thode, hote:port, auth, name, pass
			$mail->isSMTP();
			$mail->Host=$param[1];
			if ($param[2]) {
				$mail->SMTPAuth=true ;
				$mail->Username=$param[3] ;
				$mail->Password=$param[4] ;
				if ($param[5]) {
					$mail->SMTPSecure = $param[5]; // pour traitement connexion SSL
					$mail->SMTPAutoTLS=true;
				}
			}
			break ;
		default:
		case 'php':
			$mail->isMail();
			$to_nom="";
			break;
	}

	if ($pmb_mail_html_format) {
		$mail->isHTML(true);
	}
	
	if (trim($pmb_mail_adresse_from)) {
		$tmp_array_email = explode(';',$pmb_mail_adresse_from);
		if (!isset($tmp_array_email[1])) {
			$tmp_array_email[1]='';
		}
		$mail->setFrom($tmp_array_email[0],$tmp_array_email[1]);		
	} else {
		$mail->setFrom($from_mail,$from_name);
	}	
	
	for ($i=0; $i<count($destinataires); $i++) {
		$mail->addAddress($destinataires[$i], $to_nom);
	}
	for ($i=0; $i<count($destinataires_CC); $i++) {
		$mail->addCC($destinataires_CC[$i]);
	}
	for ($i=0; $i<count($destinataires_BCC); $i++) {
		$mail->addBCC($destinataires_BCC[$i]);
	}
	$mail->addReplyTo($from_mail, $from_name);	
	$mail->Subject=$obj;
	if ($pmb_mail_html_format) {
		if ($faire_nl2br) {
			$mail->Body=wordwrap(nl2br($corps),70);
		} else {
			$mail->Body=wordwrap($corps,70);
		}
		if ($pmb_mail_html_format==2) {
			$mail->MsgHTML($mail->Body);
		}
	} else {
		$corps=str_replace("<hr />",PHP_EOL."*******************************".PHP_EOL,$corps);
		$corps=str_replace("<hr />",PHP_EOL."*******************************".PHP_EOL,$corps);
		$corps=str_replace("<br />",PHP_EOL,$corps);
		$corps=str_replace("<br />",PHP_EOL,$corps);
		$corps=str_replace(PHP_EOL.PHP_EOL.PHP_EOL,PHP_EOL.PHP_EOL,$corps);
		$corps=strip_tags($corps);
		$corps=html_entity_decode($corps,ENT_QUOTES, $charset) ;
		$mail->Body=wordwrap($corps,70);
	}
	for ($i=0; $i<count($pieces_jointes) ; $i++) {
		if ($pieces_jointes[$i]["contenu"] && $pieces_jointes[$i]["nomfichier"]) {
			$mail->addStringAttachment($pieces_jointes[$i]["contenu"], $pieces_jointes[$i]["nomfichier"]) ;
		}	
	}		

	if (!$mail->send()) {
		$retour=false;
		global $error_send_mail ;
		$error_send_mail[] = $mail->ErrorInfo ;
		 //echo $mail->ErrorInfo."<br /><br /><br /><br />";
		 //echo $mail->Body ;
		} else {
			$retour=true ;
		}
	if ($param[0]=='smtp') {
		$mail->smtpClose();
	}
	unset($mail);

	return $retour ;
}
