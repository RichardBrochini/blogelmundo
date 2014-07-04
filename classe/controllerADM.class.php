<?php

class controllerADM{

    public function controllerADM($acao) {
		$html = new GerarHtml();
	   	switch($acao){
			case 'login':	   		
				if($_SESSION['logadoAdm']==1 && $_SESSION['login']!=''){
					echo $html->header();
					echo $html->menuAdm();
					echo $html->fooder();							
				}else{
					$usuario         = new Usuario();
					$usuario->login  = $_POST['login'];
					$usuario->senha  = $_POST['senha'];
					if($usuario->validarLogin()){
						$_SESSION['logadoAdm'] = 1;
						$_SESSION['login']     = strtolower(trim($usuario->login));
						echo $html->header();
						echo $html->menuAdm();
						echo $html->fooder();							
					}else{
						echo $html->header();
						echo $html->loginHome();
						echo $html->fooder();							
					}
				}
			break;
			case 'adm':	   		
				if($_SESSION['logadoAdm']==1 && $_SESSION['login']!=''){
					$html->dados['tipo'] = trim($_GET['tipo']);
					echo $html->header();
					echo $html->menuAdm();
					echo $html->subMenuAdm();
					echo $html->fooder();							
				}else{
					echo $html->header();
					echo $html->loginHome();
					echo $html->fooder();							
				}
			break;
			case 'confs':	   		
				if($_SESSION['logadoAdm']==1 && $_SESSION['login']!=''){
					$html->dados['tipo'] = trim($_GET['tipo']);
					$html->dados['url']  = Config::$url;
					echo $html->header();
					echo $html->menuAdm();
					echo $html->confs();
					echo $html->fooder();							
				}else{
					echo $html->header();
					echo $html->loginHome();
					echo $html->fooder();							
				}
			break;
			case 'novo':	   		
				if($_SESSION['logadoAdm']==1 && $_SESSION['login']!=''){
					$html->dados['tipo']=trim($_GET['tipo']);
					echo $html->header();
					echo $html->menuAdm();
					echo $html->subMenuAdm();
					switch ($html->dados['tipo']) {
						case'texto':
							echo $html->formTexto();														
						break;
						case'video':
							echo $html->formVideo();														
						break;
						case'foto':
							echo $html->formFoto();														
						break;
					}
					echo $html->fooder();							
				}else{
					echo $html->header();
					echo $html->loginHome();
					echo $html->fooder();							
				}
			break;
			case 'cadastrar':	   		
				if($_SESSION['logadoAdm']==1 && $_SESSION['login']!=''){
					$html->dados['tipo']=trim($_GET['tipo']);
					echo $html->header();
					echo $html->menuAdm();
					echo $html->subMenuAdm();
					switch ($html->dados['tipo']) {
						case'video':
							$video = new Video();
							$video->login = $_SESSION['login'];
							$video->carregar();
							$video->adicionarElemento(array(							
							'id'=>$video->pegarId(),
							'data'=>date("d/m/Y H:i"),
							'titulo'=>htmlentities($_POST['titulo']),
							'video'=>$_POST['video'],
							'texto'=>htmlentities($_POST['texto'])));
							$video->gerarXml();
							$vetor    = $video->dados();
							$conteudo="<table>";
							$conteudo=$conteudo."<tr>" .
													"<td>Titulo</td>" .
													"<td>Dia</td>" .
													"<td></td>" .
													"<td></td>" .
												"</tr>";
							$x=0;
							while($vetor[$x]){
								$conteudo=$conteudo."<tr>" .
														"<td>".$vetor[$x]['titulo']."</td>" .
														"<td>".$vetor[$x]['data']."</td>" .
														"<td><a href='?acao=excluir&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>excluir</a></td>" .
														"<td><a href='?acao=ver&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>ver</a></td>" .
													"</tr>";
								$x++;	
							}
							$conteudo=$conteudo."</table>";
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaVideoAdm();
						break;
						case'texto':
							$texto = new Texto();
							$texto->login = $_SESSION['login'];
							$texto->carregar();
							$texto->adicionarElemento(array(							
							'id'=>$texto->pegarId(),
							'data'=>date("d/m/Y H:i"),
							'titulo'=>htmlentities($_POST['titulo']),
							'texto'=>htmlentities($_POST['texto'])));
							$texto->gerarXml();
							$vetor    = $texto->dados();
							$conteudo="<table>";
							$conteudo=$conteudo."<tr>" .
													"<td>Titulo</td>" .
													"<td>Dia</td>" .
													"<td></td>" .
													"<td></td>" .
												"</tr>";
							$x=0;
							while($vetor[$x]){
								$conteudo=$conteudo."<tr>" .
														"<td>".$vetor[$x]['titulo']."</td>" .
														"<td>".$vetor[$x]['data']."</td>" .
														"<td><a href='?acao=excluir&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>excluir</a></td>" .
														"<td><a href='?acao=ver&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>ver</a></td>" .
													"</tr>";
								$x++;	
							}
							$conteudo=$conteudo."</table>";
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaTextoAdm();
						break;
						case 'foto':
							$foto = new Foto();
							$img = new UploadImg();
							$foto->login = $_SESSION['login'];
							$foto->carregar();
							$tipo = explode(".",$_FILES['foto']['name']);
							$img->tipo          = $tipo[count($tipo)-1];
							$img->largura       = Config::$fotoLargura;
							$img->altura        = Config::$fotoAltura;
							$img->uploaddir     = $foto->login."/fotos/";
							$img->hash          = sha1(date("his").$foto->login.date("ymd"));
							$foto->adicionarElemento(array(							
							'id'=>$foto->pegarId(),
							'data'=>date("d/m/Y H:i"),
							'titulo'=>htmlentities($_POST['titulo']),
							'url'=>str_replace($foto->login."/", "",$img->upload($_FILES['foto'])).$img->hash.".".$img->tipo,
							'texto'=>htmlentities($_POST['texto'])));
							$foto->gerarXml();
							$vetor    = $foto->dados();
							$conteudo="<table>";
							$conteudo=$conteudo."<tr>" .
													"<td>Titulo</td>" .
													"<td>Dia</td>" .
													"<td></td>" .
													"<td></td>" .
												"</tr>";
							$x=0;
							while($vetor[$x]){
								$conteudo=$conteudo."<tr>" .
														"<td>".$vetor[$x]['titulo']."</td>" .
														"<td>".$vetor[$x]['data']."</td>" .
														"<td><a href='?acao=excluir&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>excluir</a></td>" .
														"<td><a href='?acao=ver&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>ver</a></td>" .
													"</tr>";
								$x++;	
							}
							$conteudo=$conteudo."</table>";
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaFotoAdm();
						break;
					}
					echo $html->fooder();							
					$usuario        = new Usuario();
					$usuario->login = $_SESSION['login'];							
					$usuario->gerarIndex();
				}else{
					echo $html->header();
					echo $html->loginHome();
					echo $html->fooder();							
				}
			break;
			case 'lista':	   		
				if($_SESSION['logadoAdm']==1 && $_SESSION['login']!=''){
					$html->dados['tipo']=trim($_GET['tipo']);
					echo $html->header();
					echo $html->menuAdm();
					echo $html->subMenuAdm();
					switch ($html->dados['tipo']) {
						case 'video':
							$video = new Video();
							$video->login = $_SESSION['login'];
							$video->carregar();
							$vetor    = $video->dados();
							$conteudo="<table>";
							$conteudo=$conteudo."<tr>" .
													"<td>Titulo</td>" .
													"<td>Dia</td>" .
													"<td></td>" .
													"<td></td>" .
												"</tr>";
							$x=0;
							while($vetor[$x]){
								$conteudo=$conteudo."<tr>" .
														"<td>".$vetor[$x]['titulo']."</td>" .
														"<td>".$vetor[$x]['data']."</td>" .
														"<td><a href='?acao=excluir&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>excluir</a></td>" .
														"<td><a href='?acao=ver&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>ver</a></td>" .
													"</tr>";
								$x++;	
							}
							$conteudo=$conteudo."</table>";
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaVideoAdm();
						break;
						case'texto':
							$texto = new Texto();
							$texto->login = $_SESSION['login'];
							$texto->carregar();
							$vetor    = $texto->dados();
							$conteudo="<table>";
							$conteudo=$conteudo."<tr>" .
													"<td>Titulo</td>" .
													"<td>Dia</td>" .
													"<td></td>" .
													"<td></td>" .
												"</tr>";
							$x=0;
							while($vetor[$x]){
								$conteudo=$conteudo."<tr>" .
														"<td>".$vetor[$x]['titulo']."</td>" .
														"<td>".$vetor[$x]['data']."</td>" .
														"<td><a href='?acao=excluir&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>excluir</a></td>" .
														"<td><a href='?acao=ver&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>ver</a></td>" .
													"</tr>";
								$x++;	
							}
							$conteudo=$conteudo."</table>";
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaTextoAdm();
						break;
						case 'foto':
							$foto = new Foto();
							$foto->login = $_SESSION['login'];
							$foto->carregar();
							$vetor    = $foto->dados();
							$conteudo="<table>";
							$conteudo=$conteudo."<tr>" .
													"<td>Titulo</td>" .
													"<td>Dia</td>" .
													"<td></td>" .
													"<td></td>" .
												"</tr>";
							$x=0;
							while($vetor[$x]){
								$conteudo=$conteudo."<tr>" .
														"<td>".$vetor[$x]['titulo']."</td>" .
														"<td>".$vetor[$x]['data']."</td>" .
														"<td><a href='?acao=excluir&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>excluir</a></td>" .
														"<td><a href='?acao=ver&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>ver</a></td>" .
													"</tr>";
								$x++;	
							}
							$conteudo=$conteudo."</table>";
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaFotoAdm();						
						break;
					}
					echo $html->fooder();							
				}else{
					echo $html->header();
					echo $html->loginHome();
					echo $html->fooder();							
				}
			break;
			case 'ver':	   		
				if($_SESSION['logadoAdm']==1 && $_SESSION['login']!=''){
					$html->dados['tipo']=trim($_GET['tipo']);
					echo $html->header();
					echo $html->menuAdm();
					echo $html->subMenuAdm();
					switch ($html->dados['tipo']) {
						case'foto':
							$foto = new Foto();
							$foto->login = $_SESSION['login'];
							$foto->carregar();
							$vetor                = $foto->dados();
							$html->dados['foto'] = $vetor[trim($_GET['id'])]['url'];
							$conteudo=$vetor[trim($_GET['id'])]['titulo']."<br/>".$html->embedFoto()."<br/>".$vetor[trim($_GET['id'])]['texto'];
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaFotoAdm();
						break;
						case'video':
							$video = new Video();
							$video->login = $_SESSION['login'];
							$video->carregar();
							$vetor                = $video->dados();
							$html->dados['video'] = $vetor[trim($_GET['id'])]['url'];
							$conteudo=$vetor[trim($_GET['id'])]['titulo']."<br/>".$html->embedVideo()."<br/>".$vetor[trim($_GET['id'])]['texto'];
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaVideoAdm();
						break;
						case'texto':
							$texto = new Texto();
							$texto->login = $_SESSION['login'];
							$texto->carregar();
							$vetor    = $texto->dados();
							$conteudo=$vetor[trim($_GET['id'])]['titulo']."<br/>".$vetor[trim($_GET['id'])]['texto'];
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaTextoAdm();
						break;
					}
					echo $html->fooder();							
				}else{
					echo $html->header();
					echo $html->loginHome();
					echo $html->fooder();							
				}
			break;
			case 'excluir':	   		
				if($_SESSION['logadoAdm']==1 && $_SESSION['login']!=''){
					$html->dados['tipo']=trim($_GET['tipo']);
					echo $html->header();
					echo $html->menuAdm();
					echo $html->subMenuAdm();
					switch ($html->dados['tipo']) {
						case'video':
							$video = new Video();
							$video->login = $_SESSION['login'];
							$video->excluir(trim($_GET['id']));
							$vetor    = $video->dados();
							$conteudo="<table>";
							$conteudo=$conteudo."<tr>" .
													"<td>Titulo</td>" .
													"<td>Dia</td>" .
													"<td></td>" .
													"<td></td>" .
												"</tr>";
							$x=0;
							while($vetor[$x]){
								$conteudo=$conteudo."<tr>" .
														"<td>".$vetor[$x]['titulo']."</td>" .
														"<td>".$vetor[$x]['data']."</td>" .
														"<td><a href='?acao=excluir&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>excluir</a></td>" .
														"<td><a href='?acao=ver&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>ver</a></td>" .
													"</tr>";
								$x++;	
							}
							$conteudo=$conteudo."</table>";
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaVideoAdm();
						break;
						case'texto':
							$texto = new Texto();
							$texto->login = $_SESSION['login'];
							$texto->excluir(trim($_GET['id']));
							$vetor    = $texto->dados();
							$conteudo="<table>";
							$conteudo=$conteudo."<tr>" .
													"<td>Titulo</td>" .
													"<td>Dia</td>" .
													"<td></td>" .
													"<td></td>" .
												"</tr>";
							$x=0;
							while($vetor[$x]){
								$conteudo=$conteudo."<tr>" .
														"<td>".$vetor[$x]['titulo']."</td>" .
														"<td>".$vetor[$x]['data']."</td>" .
														"<td><a href='?acao=excluir&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>excluir</a></td>" .
														"<td><a href='?acao=ver&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>ver</a></td>" .
													"</tr>";
								$x++;	
							}
							$conteudo=$conteudo."</table>";
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaTextoAdm();
						break;
						case 'foto':
							$foto = new Foto();
							$foto->login = $_SESSION['login'];
							$foto->excluir(trim($_GET['id']));
							$vetor    = $foto->dados();
							$conteudo="<table>";
							$conteudo=$conteudo."<tr>" .
													"<td>Titulo</td>" .
													"<td>Dia</td>" .
													"<td></td>" .
													"<td></td>" .
												"</tr>";
							$x=0;
							while($vetor[$x]){
								$conteudo=$conteudo."<tr>" .
														"<td>".$vetor[$x]['titulo']."</td>" .
														"<td>".$vetor[$x]['data']."</td>" .
														"<td><a href='?acao=excluir&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>excluir</a></td>" .
														"<td><a href='?acao=ver&tipo=".$html->dados['tipo']."&id=".$vetor[$x]['id']."'>ver</a></td>" .
													"</tr>";
								$x++;	
							}
							$conteudo=$conteudo."</table>";
							$html->dados['conteudo'] = $conteudo;
							echo $html->listaFotoAdm();						
						break;
					}
					echo $html->fooder();
					$usuario        = new Usuario();
					$usuario->login = $_SESSION['login'];							
					$usuario->gerarIndex();
				}else{
					echo $html->header();
					echo $html->loginHome();
					echo $html->fooder();							
				}
			break;
			default:
				if($_SESSION['logadoAdm']==1 && $_SESSION['login']!=''){
					echo $html->header();
					echo $html->menuAdm();
					echo $html->fooder();							
				}else{
					echo $html->header();
					echo $html->loginHome();
					echo $html->fooder();							
				}
			break;    	   		
	   	}
    }
}
?>