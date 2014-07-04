<?php
session_start();
include_once('config.php');
$acao = trim($_POST['acao']);
switch ( $acao ) {
	case 'salvar.cor':
		if($_SESSION['logadoAdm']==1 && $_SESSION['login']!=''){
	 		if(file_exists(Config::$dir.strtolower(trim($_SESSION['login']))."/css.xml")){
				$xml = simplexml_load_file(Config::$dir.strtolower(trim($_SESSION['login']))."/css.xml");
				$html = new GerarHtml();
				$html->dados['painel']        = $xml->painel;
				$html->dados['link']          = $xml->link;
				$html->dados['fundo']         = $xml->fundo;
				$html->dados['fonte']         = $xml->fonte;					
				if($_POST['nome']=='conteudo'){
					$html->dados['painel']        = $_POST['valor'];					
				}
				if($_POST['nome']=='fundo'){
					$html->dados['fundo']         = $_POST['valor'];					
				}
				if($_POST['nome']=='link'){
					$html->dados['link']          = $_POST['valor'];					
				}
				if($_POST['nome']=='font'){
					$html->dados['fonte']         = $_POST['valor'];										
				}
				$arquivo = new Arquivo();
				$arquivo->nome         = "template.css";
				$arquivo->diretorio    = Config::$dir."/".trim($_SESSION['login'])."/css/";
				$arquivo->conteudo     = $html->css();
				$arquivo->gerar();		
				$xml = '<?xml version="1.0" encoding="UTF-8"?>' .
					'<corpo>' .
						'<painel><![CDATA['.$html->dados['painel'].']]></painel>'.
						'<link><![CDATA['.$html->dados['link'].']]></link>'.
						'<fundo><![CDATA['.$html->dados['fundo'].']]></fundo>'.
						'<fonte><![CDATA['.$html->dados['fonte'].']]></fonte>'.
					'</corpo>';
				$arquivo->nome      = "css.xml";
				$arquivo->diretorio    = Config::$dir."/".trim($_SESSION['login'])."/";
				$arquivo->conteudo  = $xml;
				$arquivo->gerar();				
	 		}
		}	
		break;
		case 'indicar':
			$html  = new GerarHtml();
			$html->dados['link'] = $_SERVER['HTTP_REFERER'];
			$email = new Email();
			$email->setAssunto("Um Amigo Achou um Blog Legal na Net");
			$email->setFrom("no-reply@blogxml.com");
			$email->setDestinatarios($_POST['email']);
			$email->setMensagem($html->emailIndicar());
			//$email->enviar();
		break;
}
?>