<?php
/**********************************************************************
Filename:	SendEmail.class.php
Function:	Make an email and send
Author:		Ahdong
Email:		ahdong@126.com
Version:	0.1beta060918 For PHP4
**********************************************************************/
class SendEmail
{
    /**
    * Public
    * $SMTP_SERVER_ADDR the smtp server address(SMTP服务器地址)
    */
	var $SMTP_SERVER_ADDR = "smtp.163.com";			

    /**
    * Public
    * $SMTP_DOMAIN the domain of smtp server()
    */
	var $SMTP_DOMAIN = "smtp.163.com";

    /**
    * Public
    * $charset the charset of email()
    */
	var $charset 		=	"utf-8";

    /**
    * Public
    * $encoding	the method of encoding the email,use base64 if $charset is not gb2312()
    * Values:base64|quoted-printable
    */
	var $encoding		=	"base64";
	
    /**
    * Public
    * $subject subject of email()
    */
	var $subject = "";
	
    /**
    * Public
    * $fromName name of sender()
    */
	var $fromName	= "";

    /**
    * Public
    * $fromEmail email of sender()
    */	
	var $fromEmail;

    /**
    * Public
    * $replytoName name of person whom reply to()
    */	
	var $replytoName	= "";

    /**
    * Public
    * $replytoEmail email which reply to()
    */	
	var $replytoEmail;

    /**
    * Public
    * $toEmails email(s) which send to,array or single address()
    */	
	var $toEmails;

    /**
    * Public
    * $contentPlain plain content()
    */	
	var $contentPlain;			//纯文本内容

    /**
    * Public
    * $contentHtml html content(HTML格式内容)
    */	
	var $contentHtml;

    /**
    * Public
    * $contentType format of email,1.plain only,2.HTML only,3.plain and HTML(内容格式 1.仅纯文本,2.仅HTML,3.文本+HTML)
    */	
	var $contentType	=	2;	
	
    /**
    * Public
    * $attachments array of attachments()
    * $attachments[name] array of attachments' names
    * $attachments[tmp_name] array of attachments' whole pathes
    * $attachments[type] array of attachments' types
    */	
	var $attachments;
	
    /**
    * Public
    * $innerResources array of inner resources()
    * $innerResources[name] array of inner resources' names
    * $innerResources[tmp_name] array of inner resources' whole pathes
    * $innerResources[type] array of inner resources' types
    * $innerResources[cid] array of inner resources' ids
    */	
	var $innerResources;	

	/**
	* Public
	* $boundaryMixed boundary for mixed()
	*/
	var $boundaryMixed = '==11hahahahahaahdongisgodhahahahaha11==';
	
	/**
	* Public
	* $boundaryRelated boundary for related()
	*/
	var $boundaryRelated = '==22hahahahahawoodyahdonghahahahaha22==';
	
	/**
	* Public
	* $boundaryAlternative boundary for alternative()
	*/
	var $boundaryAlternative = '==33hahahahahawoodyahdonghahahahaha33==';

	/**
	* Public
	* $log file to log errors()
	*/
	var $log;
	/**
	* Private
	* $logp pointer of log file's opening()
	*/
	var $logp;
	/**
	* Private
	* $error errors occured while sending()
	*/
	var $error;
	
	/**
	* Private
	* $email generated email()
	*/
	var $email;
	
	/**
	* Private
	* $emailHead generated email's head()
	*/
	var $emailHead;
	
	/**
	* Private
	* $emailBody generated email's body()
	*/
	var $emailBody;
	
    //! A constructor(构造函数).
    /**
    * Constucts a new SendEmail object,open log file if it is set(构造新的SendEmail对象,打开日志记录文件,如果有设置的话)
    */
   	function SendEmail()
	{
		$this->contentHtml = '';
		if(!empty($this->log))
			$this->logp = fopen($this->log,'w');
	}
	
    //! A destructor(析构函数).
    /**
    * Destucts object,close log(关闭日志记录文件)
    */
	function __destruct()
	{
		if (!empty($this->logp))
			fclose($this->logp);
		/***
		$this->email = '';
		$this->emailHead = '';
		$this->emailBody = '';
		
		$this->contentPlain = '';
		***/
	}
	
    //! A manipulator(操作函数)
    /**
    * Logs errors(记录出错信息)
    * @param $msg error message (错误信息)
    */
	function logerror($msg)
	{
		if (!empty($this->logp))
			fwrite($this->logp,$msg."\n");
	}
	
    //! A manipulator(操作函数)
    /**
    * sends email(发送邮件)
    */
	function sends()
	{
		$this->makeEmail();
		//Open an SMTP connection
		$smtpfp = fsockopen($this->SMTP_SERVER_ADDR, 25, $e1, $e2, 30);
		if (!$smtpfp)
		{
			$this->error = "cannot open smtp socket.";
			$this->logerror($this->error);
			return false;
		}
		$res = fgets($smtpfp, 256);
		if (substr($res,0,3) != "220")
		{
			$this->error = "cannot get message from smtp socket.";
			$this->logerror($this->error);
			fputs($smtpfp, "QUIT\n");
			fclose ($smtpfp);
			return false;
		}
		fputs($smtpfp, "HELO ".$this->SMTP_DOMAIN."\r\n");
		$res = fgets($smtpfp, 256);
		if (substr($res,0,3) != "250")
		{
			$this->error = "HELO error.";
			$this->logerror($this->error);
			fputs($smtpfp, "QUIT\n");
			fclose ($smtpfp);
			return false;
		}
		fputs($smtpfp, "MAIL FROM: ".$this->fromEmail."\r\n");
		$res = fgets($smtpfp, 256);
		if (substr($res,0,3) != "250")
		{
			$this->error = "MAIL FROM error.";
			$this->logerror($this->error);
			fputs($smtpfp, "QUIT\n");
			fclose ($smtpfp);
			return false;
		}
		
		if(is_array($this->toEmails))
		{
			for ($i = 0,$n = count($this->toEmails); $i < $n; $i++)
			{
				fputs($smtpfp, "RCPT TO: ".$this->toEmails[$i]."\r\n");
				$res = fgets($smtpfp, 256);
				if (substr($res,0,3) != "250")
				{
					$this->error = "RCPT TO ".$this->toEmails[$i]." erro.";
					$this->logerror($this->error);
					fputs($smtpfp, "QUIT\n");
					fclose ($smtpfp);
					return false;
				}
			}
		}
		else
		{
			fputs($smtpfp, "RCPT TO: ".$this->toEmails."\r\n");
			$res = fgets($smtpfp, 256);
			if (substr($res,0,3) != "250")
			{
				$this->error = "RCPT TO ".$this->toEmails." erro.";
				$this->logerror($this->error);
				fputs($smtpfp, "QUIT\n");
				fclose ($smtpfp);
				return false;
			}
		}
		
		fputs($smtpfp, "DATA\r\n");
		$res = fgets($smtpfp,256);
		if (substr($res,0,3) != "354")
		{
			$this->error = "DATA error.";
			$this->logerror($this->error);
			fputs($smtpfp, "QUIT\n");
			fclose ($smtpfp);
			return false;
		}
		fputs($smtpfp, $this->email."\r\n.\r\n");
		$res = fgets($smtpfp,256);
		if (substr($res,0,3) != "250")
		{
			$this->error = "sending error.";
			$this->logerror($this->error);
			fputs($smtpfp, "QUIT\n");
			fclose ($smtpfp);
			return false;
		}
		fputs($smtpfp, "QUIT\n");
		$res = fgets($smtpfp, 256);
		if (substr($res,0,3) != "221")
		{
			$this->error = "cannot QUIT.";
			$this->logerror($this->error);
			fputs($smtpfp, "QUIT\n");
			fclose ($smtpfp);
			return false;
		}
		fclose ($smtpfp);

		return true;
	}
	
    //! A manipulator(操作函数)
    /**
    * generates email(生成邮件)
    */
	function makeEmail()
	{
		if(empty($this->emailHead))
			$this->makeHead();
		if(empty($this->emailBody))
			$this->makeBody();
			
		$emailList = '';
		if(is_array($this->toEmails))
		{
			for ($i = 0,$n = count($this->toEmails); $i < $n; $i++)
			{
					$emailList .= (empty($emailList)) ? "<".$this->toEmails[$i].">" :  ", <".$this->toEmails[$i].">,";
			}
		}
		else
		{
			$emailList = "<".$this->toEmails.">";
		}

		$this->email = $this->emailHead;
		$this->email .= "To: " . $emailList . "\r\n";
		$this->email .= "Mime-Version: 1.0\r\n";
		$this->email .= $this->emailBody;
	}
	
    //! A manipulator(操作函数)
    /**
    * generates email body(生成邮件主体)
    */
	function makeBody()
	{
		$this->emailBody = $this->makeMixed();
	}
	
    //! A manipulator(操作函数)
    /**
    * generates related part(生成related部分)
    * @return String
    */
	function makeRelated()
	{
		if (empty($this->innerResources))
			return $this->makeAlternative();
		else
		{
			$resources = '';
			for ($i = 0; $i < count($this->innerResources[name]); $i ++)
			{
				$resource_fp = fopen($this->innerResources[tmp_name][$i], "r");
				$resource_contents = fread($resource_fp, filesize ($this->innerResources[tmp_name][$i]));
				fclose($resource_fp);
				$resources .= "--".$this->boundaryRelated."\r\n";
				$resources .= "Content-Type: " . $this->innerResources[type][$i] . ";\n";
				$resources .= "\t name=\"" . "=?" . $this->charset . "?B?" . base64_encode($this->innerResources[name][$i]) . "?=" .  "\"\r\n";
				$resources .= "Content-Transfer-Encoding: base64\r\n";
				$resources .= "Content-ID: <".$this->innerResources[cid][$i].">\r\n";
				$resources .= "\r\n";
				$resources .= chunk_split(base64_encode($resource_contents));
				$resources .= "\r\n";
			}
			
			$related = '';
			$related .= "Content-Type: multipart/related; type=\"multipart/related\";\r\n";
			$related .= "\t boundary=\"" . $this->boundaryRelated . "\"\r\n";
			$related .= "\r\n";
			$related .= "--" . $this->boundaryRelated . "\r\n";
			$related .= $this->makeAlternative() . "\r\n";
			$related .= $resources . "\r\n";
			$related .= "--" . $this->boundaryRelated . "--\r\n";
			
			return $related;	
		}
	}
	
    //! A manipulator(操作函数)
    /**
    * generates Mixed part(生成Mixed部分)
    * @return String
    */
	function makeMixed()
	{
		if (empty($this->attachments))
			return $this->makeRelated();
		else
		{
			$attachments = '';
			for ($i = 0; $i < count($this->attachments[name]); $i ++)
			{
				$attachment_fp = fopen($this->attachments[tmp_name][$i], "r");
				$attachment_contents = fread($attachment_fp, filesize ($this->attachments[tmp_name][$i]));
				fclose($attachment_fp);
				$attachments .= "--".$this->boundaryMixed."\r\n";
				$attachments .= "Content-Type: " . $this->attachments[type][$i] . ";\n";
				$attachments .= "\t name=\"" . "=?" . $this->charset . "?B?" . base64_encode($this->attachments[name][$i]) . "?=" .  "\"\r\n";
				$attachments .= "Content-Transfer-Encoding: base64\r\n";
				$attachments .= "Content-Disposition: attachment;\n";
				$attachments .= "\t filename=\"" . "=?" . $this->charset . "?B?" . base64_encode($this->attachments[name][$i]) . "?=" . "\"\r\n";
				$attachments .= "\r\n";
				$attachments .= chunk_split(base64_encode($attachment_contents));
				$attachments .= "\r\n";
			}

			$mixed = '';
			$mixed .= "Content-Type: multipart/mixed; type=\"multipart/mixed\";\r\n";
			$mixed .= "\t boundary=\"" . $this->boundaryMixed . "\"\r\n";
			$mixed .= "\r\n";
			$mixed .= "--" . $this->boundaryMixed . "\r\n";
			$mixed .= $this->makeRelated() . "\r\n";
			$mixed .= $attachments . "\r\n";
			$mixed .= "--" . $this->boundaryMixed . "--\r\n";
			
			return $mixed;	
		}
	}
	
    //! A manipulator(操作函数)
    /**
    * generates Alternative part(生成Alternative部分)
    * @return String
    */
	function makeAlternative()
	{
		if($this->contentType == 1)
		{
			return $this->makePlain();
		}
		else if($this->contentType == 2)
		{
			return $this->makeHtml();
		}
		else
		{
			$alternative = '';
			$alternative .= "Content-Type: multipart/alternative;\r\n";
			$alternative .= "\t boundary=\"" . $this->boundaryAlternative . "\"\r\n";
			$alternative .= "This is a multi-part message in MIME format.\r\n";
			$alternative .= "\r\n";
			$alternative .= "--" . $this->boundaryAlternative . "\r\n";
			$alternative .= $this->makePlain() . "\r\n";
			$alternative .= "--" . $this->boundaryAlternative . "\r\n";
			$alternative .= $this->makeHtml() . "\r\n";
			$alternative .= "--" . $this->boundaryAlternative . "--\r\n";
			return $alternative;
		}
	}
	
    //! A manipulator(操作函数)
    /**
    * generates Plain part(生成Plain部分)
    * @return String
    */
	function makePlain()
	{
		if (empty($this->contentPlain))
			$this->contentPlain = strip_tags($this->contentHtml);
		
		$contentPlain = '';
		switch($this->encoding)
		{
			case 'quoted-printable':
				$contentPlain = $this->encode_8bit($this->contentPlain);
				break;
			case 'base64':
				$contentPlain = chunk_split(base64_encode(StripSlashes($this->contentPlain)));
				break;
		}

		$plain = '';//$email_plain//
		$plain .= "Content-Type: text/plain; charset=\"".$this->charset."\"\r\n";
		$plain .= "Content-Transfer-Encoding: ".$this->encoding."\r\n";
		$plain .= "\r\n";
		$plain .= $contentPlain."\r\n";
		return $plain;
	}
	
    //! A manipulator(操作函数)
    /**
    * generates Html part(生成Html部分)
    * @return String
    */
	function makeHtml()
	{
		$contentHtml = '';
		switch($this->encoding)
		{
			case 'quoted-printable':
				$contentHtml = $this->encode_8bit($this->contentHtml);
				break;
			case 'base64':
				$contentHtml = chunk_split(base64_encode(StripSlashes($this->contentHtml)));
				break;
		}

		$html = '';//$email_plain//
		$html .= "Content-Type: text/html; charset=\"".$this->charset."\"\r\n";
		$html .= "Content-Transfer-Encoding: ".$this->encoding."\r\n";
		$html .= "\r\n";
		$html .= $contentHtml."\r\n";
		return $html;	
	}

    //! A manipulator(操作函数)
    /**
    * generates email head(生成邮件头)
    */
	function makeHead()
	{
		$fromName = $this->fromName;
		$replytoName = $this->replytoEmail;
		$subject = $this->subject;
		$withReplyto = (!empty($this->replytoEmail));
		
		switch($this->encoding)
		{
			case 'quoted-printable':
				$fromName = ( ($fromName = $this->encode_8bit($this->fromName)) == $this->fromName ) ? $this->fromName : "=?".$this->charset."?Q?".$fromName."?=";
				if ($withReplyto)
					$replytoName = ( ($replytoName = $this->encode_8bit($this->replytoName)) == $this->replytoName ) ? $this->replytoName : "=?".$this->charset."?Q?".$replytoName."?=";
				$subject = ( ($subject = $this->encode_8bit($this->subject)) == $this->subject) ? $this->subject : "=?".$this->charset."?Q?".$subject."?=";
				break;
			case 'base64':
				$fromName = "=?".$this->charset."?B?".base64_encode($this->fromName)."?=";
				if ($withReplyto)
					$replytoName = "=?".$this->charset."?B?".base64_encode($this->replytoName)."?=";
				$subject = "=?".$this->charset."?B?".base64_encode($this->subject)."?=";
				break;
		}
		/***************************************
		$toMails = '';
		if (is_array($this->toEmails))
		{
			for ($i = 0,$l = count($this->toEmails); $i < $l; $i ++)
			{
				$toMails .= (empty($toMails)) ? "<".$toMails.">" : ", <".$toMails.">";
			}
		}
		else
		{
			$toMails = "<".$this->toEmails.">";
		}
		****************************************/

		$header  = '';
		$header .= "X-Mailer: Woody Mailbox!\r\n";
		$header .= "Date: " . date("D, j M Y H:i:s O") . "\r\n";
		$header .= "Subject: " . $subject . "\r\n";
		$header .= "From: \"" . $fromName . "\" <" . $this->fromEmail . ">\r\n";
		if ($withReplyto)
			$header .= "Reply-To: \"" . $replytoName . "\" <" . $this->replytoEmail . ">\r\n";
		//$header .= "To: " . $toMails . ">\r\n";
		//$header .= "Mime-Version: 1.0\r\n";
		
		$this->emailHead = $header;
	}
	
    //! A manipulator(操作函数)
    /**
    * writes email to file(将邮件写入文件)
    * @param $file file name
    */
	function writeEmail($file)
	{
		$fp = fopen($file,'w');
		fwrite($fp,$this->email);
		fclose($fp);
	}
	
    //! A manipulator(操作函数)
    /**
    * gets $this->error(获得$this->error)
    * @return String
    */
	function getError()
	{
		return $this->error;
	}
	
    //! A manipulator(操作函数)
    /**
    * Encods text to 8bit(8bit 编码)
    * @param $subtxt tetx to be encoded
    * @return String
    */
	function encode_8bit($subtxt)
	{
		$round = strlen($subtxt);
		for ($i=0; $i < $round; $i++)
		{
			if (ord($subtxt[$i]) >= 160)
			{
				$tempstr1 = dechex(ord($subtxt[$i]));
				$tempstr2 = dechex(ord($subtxt[$i+1]));
				$str .= "=".$tempstr1."=".$tempstr2;
				$i++;
			}else
			{
				$str.=$subtxt[$i];
			}
		}
		return $str;
	}
	
	//! A manipulator(操作函数)
    /**
    * clear cache(清空缓存)
    */	
	function clear()
	{
		$this->emailHead = '';
		$this->emailBody = '';
	}

}
?>
