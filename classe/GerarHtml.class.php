<?php

class GerarHtml {
    private $arquivo;
    public  $dados;
	public function GerarHtml(){
		$this->arquivo = new Arquivo();
	}
	public function header(){
		$this->arquivo->nome      = "header.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->arquivo->ler();
	}
	public function fooder(){
		$this->arquivo->nome      = "fooder.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->arquivo->ler();		
	}
	public function admPHP(){
		$this->arquivo->nome      = "adm.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->arquivo->ler();				
	}
	public function loginHome(){
		$this->arquivo->nome      = "login.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->arquivo->ler();				
	}
	public function msg(){
		$this->arquivo->nome      = "msg.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());				
	}
	public function usuarioCadastrado(){
		$this->arquivo->nome      = "usuarioCadastrado.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());				
	}
	public function menuAdm(){
		$this->arquivo->nome      = "menuAdm.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->arquivo->ler();						
	}
	public function subMenuAdm(){
		$this->arquivo->nome      = "subMenuAdm.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function formTexto(){
		$this->arquivo->nome      = "formTexto.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function formVideo(){
		$this->arquivo->nome      = "formVideo.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function formFoto(){
		$this->arquivo->nome      = "formFoto.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function listaTextoAdm(){
		$this->arquivo->nome      = "listaTextoAdm.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}	
	public function listaVideoAdm(){
		$this->arquivo->nome      = "listaVideoAdm.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function listaFotoAdm(){
		$this->arquivo->nome      = "listaFotoAdm.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function embedVideo(){
		$this->arquivo->nome      = "embedVideo.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function embedFoto(){
		$this->arquivo->nome      = "embedFoto.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function textoIndex(){
		$this->arquivo->nome      = "textoIndex.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function videoIndex(){
		$this->arquivo->nome      = "videoIndex.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function fotoIndex(){
		$this->arquivo->nome      = "fotoIndex.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function index(){
		$this->arquivo->nome      = "index.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function css(){
		$this->arquivo->nome      = "css.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function confs(){
		$this->arquivo->nome      = "confs.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	public function emailIndicar(){
		$this->arquivo->nome      = "emailIndicar.tpl";
		$this->arquivo->diretorio = Config::$dir."/template/";
		return $this->mudarDados($this->arquivo->ler());						
	}
	private function mudarDados($conteudo){
		if(is_array($this->dados)){
			foreach ($this->dados as $nome => $valor){
				$conteudo = str_replace("{".$nome."}",$valor,$conteudo);
			}	
			return $conteudo;									
		}else{
			return $conteudo;									
		}				
	}	
}
?>