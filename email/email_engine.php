<?php
/* remember that functions in CLASSES CAN'T TAKE the FINAL ; in } */


class email_engine_class {
	public $to;
	public $cc;
	public $bcc;
	public $from; /* "Joe" <joe@example.com> */
	public $return_path; /* <joe@example.com> */

	public $display_preview;
	public $template;
	public $template_location;

	public $subject;
	public $full_email_content=array();
	public $message;
	
	public $images = array();
	public $attachments = array();

	public $code;

	function send_email($staticvars){
		$this->define_email($staticvars);
		return $this->finish_and_send_email($staticvars);
	}
	
	function define_email($staticvars){
        include($staticvars['local_root'].'kernel/staticvars.php');
		if($this->template_location==''):
			$this->template_location=$staticvars['local_root'].'email/templates/';
		else:
		endif;
		if (is_dir($this->template_location.$this->template)):
			$dir_files = glob($this->template_location.$this->template.'/*.gif');
			$k=0;
			if ($dir_files<>''):
				for ($i=0;$i<count($dir_files);$i++):
					$this->images[$k]=$dir_files[$i];
					$k++;
				endfor;
			endif;
			$dir_files = glob($this->template_location.$this->template.'/*.jpg');
			if ($dir_files<>''):
				for ($i=0;$i<count($dir_files);$i++):
					$this->images[$k]=$dir_files[$i];
					$k++;
				endfor;
			endif;
		endif;
		$user=$db->getquery("select nick, email, nome from users where email='".$this->to."'");
		if ($user[0][0]==''):
			$user[0][0]=$this->to;
			$user[0][1]=$this->to;
			$user[0][2]=$this->to;
		endif;
		$this->code=file_get_contents($this->template_location.$this->template.'.html');
		$this->code=str_replace("{site_name}",$staticvars['name'],$this->code);
		$this->code=str_replace("{site_path}",$staticvars['site_path'],$this->code);
		$this->code=str_replace("{user_nick}",$user[0][0],$this->code);
		$this->code=str_replace("{user_email}",$user[0][1],$this->code);
		$this->code=str_replace("{user_nome}",$user[0][2],$this->code);
		$this->code=str_replace("{message}",$this->message,$this->code);
		$this->full_email_content=$this->code;
		if ($this->preview==true):
			$_SESSION['codice']=$this->code;
			$link=session($staticvars,$staticvars['site_path'].'/email/preview.php');
echo '<a href="#" onclick="javascript:window.open(\''.$link.'\', \'Preview\', \'status = 1, height = 500, width = 800, resizable = 0, scrollbars=yes\' );">ver email enviado</a>';
		endif;
	}

	function finish_and_send_email($staticvars){
        include($staticvars['local_root'].'kernel\\staticvars.php');
		include($staticvars['local_root'].'email\\htmlMimeMail5.php');
    	$mail = new htmlMimeMail5();

		/* Read the image files   */
		if ($this->images<>''):
			for ($i=0;$i<count($this->images);$i++):
    			$mail->addEmbeddedImage(new fileEmbeddedImage($this->images[$i]));
			endfor;
		endif;
        /* Read the attachement files */
		if ($this->attachments<>''):
			for ($i=0;$i<count($this->attachments);$i++):
    			$mail->addAttachment(new fileAttachment($this->attachments[$i]));
			endfor;
		endif;
        /*
        * Get the contents of the example text/html files.
		* Text/html data doesn't have to come from files,
		* could come from anywhere.
        */
    	$mail->setText($this->message);
    	$mail->setHTML($this->full_email_content);
		$mail->setReturnPath($this->return_path);
		$mail->setFrom($this->from);
		$mail->setSubject($this->subject);
		$mail->setHeader('X-Mailer', $staticvars['name'].' HTML Mime mail');
		$mail->setHeader('Cc', $this->cc);
		$mail->setHeader('Bcc', $this->bcc);
    	$mail->setPriority('high');
		$mail->setSMTPParams($staticvars['smtp']['host'], 25, $staticvars['smtp']['host'], true, $staticvars['smtp']['user'], $staticvars['smtp']['password']);
		$result = $mail->send(array($this->to,''), 'smtp');
	    // These errors are only set if you're using SMTP to send the message
		if (!$result):
			return $mail->errors[0];
		else:
			return 'Email enviado!';
		endif;
	}

};// end of class
?>
