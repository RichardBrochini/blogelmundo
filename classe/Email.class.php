<?
class Email{
	private $destinatarios;
	private $assunto;
	private $mensagem;
	private $Cc;
	private $BCc;
	private $from;
	private $template;
	private $headers;
	
	public function Email(){
		$this->headers = "MIME-Version: 1.0\r\n";
		$this->headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	}
	
	public function setAssunto($var){
		if(isset($var)){
			$this->assunto = $var;  
		}  
	}
	public function setFrom($var){
		if(isset($var)){
			$this->from = $var;
			$this->headers .="From: ".$this->from."\r\n";		
			$this->headers .="Reply-To: ".$this->from."\r\n";	  
			$this->headers .="Return-Path:".$this->from."\r\n";
		}  
	}
	public function setCc($var){
		if(isset($var)){
			$this->Cc = $var;  
			$this->headers .="Cc: ".$this->Cc."\r\n";			  
		}  
	}
	public function setBCc($var){
		if(isset($var)){
			$this->BCc = implode(",",$var);  
			$this->headers .="Bcc: ".$this->BCc."\r\n";			  
		}  
	}
	public function setDestinatarios($var){
		$this->destinatarios = $var;  
		return true;
	}
	public function setMensagem($var){
		if(isset($var)){
			$this->mensagem = $var;   
		}  
	}
	public function setTemplate($var){
		$this->template=$var;  
	}
	
	public function validarEmail($email){
		   $mail_correcto = false; 
		   if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 
		      if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
		         if (substr_count($email,".")>= 1){ 
		            $term_dom = substr(strrchr ($email, '.'),1); 
		         if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 
		            $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
		            $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
		            if ($caracter_ult != "@" && $caracter_ult != "."){ 
		               $mail_correcto = true; 
		            } 
		         } 
		      } 
		   } 
		} 		
		return $mail_correcto;
	}
	
	public function enviar(){
		if(mail($this->destinatarios,
			$this->assunto, 
			$this->mensagem, 
			$this->headers
		)){
			return true;
		}else{
			return false;
		} 
	}		  
}
?>