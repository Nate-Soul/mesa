<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require ("PHPMailer/PHPMailer.php");
require ("PHPMailer/Exception.php");
require ("PHPMailer/SMTP.php");


class Email{

		
	private $siteEmailAddress = "helpdesk@mesa.com";
	private $siteTeam = SITE_NAME." Team";
	private $pathtoemail = EMAILS_DIR;
	private $devMode     = true;


    public function __construct() {
		//server settings
		$this->objMailer = new PHPMailer();
		$this->objMailer->IsSMTP();
		$this->objMailer->SMTPAuth      = true;
		$this->objMailer->SMTPKeepAlive = true;
		$this->objMailer->Host          = "smtp.mailtrap.io";
		$this->objMailer->Port          = 2525;
		$this->objMailer->Username      = "8fec1a1c408e93";
        $this->objMailer->Password      = "eb06629eafe9e7";
		$this->objMailer->SMTPSecure    = "tls";
		$this->objMailer->SMTPDebug     = false;
		$this->objMailer->do_debug		= 0;
		if($this->devMode){
			$this->objMailer->SMTPOptions   = array(
												"ssl" => array(
												"verify_peer" => false,
												"verify_peer_name" => false,
												"allowed_self_signed" => true
												)
											);
			$this->objMailer->SMTPDebug     = true;
		}
        //Recipients
		$this->objMailer->setFrom($this->siteEmailAddress, $this->siteTeam);
		$this->objMailer->addReplyTo($this->siteEmailAddress, $this->siteTeam);
	}
		  

	public function process($case = null, $array = null){
		if(!empty($case)){
			switch($case){

				case "account_activation":
				// add url to the array
				$link  			   = SITE_URL."/activate.php?email=";
				$link             .= $array["email"];
				$link             .= "&activation_code=";
				$link 			  .= $array["hash"];
				$array["link"]     = $link;
				//prepare mail subject
				$this->objMailer->Subject = "Activate Your Account";
				//prepare mail body
				$this->objMailer->MsgHTML($this->fetchEmail($case, $array));
				//prepare mail to
				$this->objMailer->addAddress($array["email"], $array["name"]);
				//prepare mail headers cc and bcc
				break;

				case "forgotten_password":
				// add url to the array
				$link   = SITE_URL."/login.php";
				$array['link'] = $link;
				//prepare mail subject
				$this->objMailer->Subject = "New Password Request";
				//prepare mail body
				$this->objMailer->MsgHTML($this->fetchEmail($case, $array));
				//prepare mail to
				$this->objMailer->addAddress($array["login"]);
				//prepare mail headers cc and bcc
				break;

				case "contact_us":
				//prepare mail subject
				$this->objMailer->Subject = "New Message From Contact Form";
				//prepare mail body
				$this->objMailer->MsgHTML($array["message"]);
				//prepare mail to
				$this->objMailer->addAddress($array['email'], $array['name']);
				//prepare mail headers cc and bcc
				break;
			}
		
		// send email
		if ($this->objMailer->send()) {
			$this->objMailer->clearAddresses();
			return true;
		}
		return false;
		
		}
	}
		

	public function fetchEmail($case = null, $array = null) {
	
		if (!empty($case)) {
			
			if (!empty($array)) {			
				foreach($array as $key => $value) {
					${$key} = $value;
				}			
			}
			
			if(file_exists($this->pathtoemail)){
				ob_start();
				require_once($this->pathtoemail."/".$case."_email.php");
				$out = ob_get_clean();
				return $this->wrapEmail($out);
			}

		}
	
	}
	

	public function wrapEmail($content = null) {
		if (!empty($content)) {
			return "<div style=\"font-family:Arial,Verdana,Sans-serif;font-size:12px;color:#333;line-height:21px;\">{$content}</div>";
		}
	}
	



	
}