<?php
require_once('config.php');
$usuario = new Usuario();
$usuario->login     = $_POST['login'];
$usuario->senha     = $_POST['senha'];
$usuario->titulo    = $_POST['titulo'];
$usuario->descricao = $_POST['descricao'];
$html = new GerarHtml();
echo $html->header();	
if($usuario->cadastrar()){
	$html->dados['link'] = Config::$url.$usuario->login."/";
	echo $html->usuarioCadastrado();	
}else{
	$html->dados['msg'] = "Esse Login ja esta cadastrado.";
	echo $html->msg();		
}
echo $html->fooder();
?>