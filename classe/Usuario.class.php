<?php
class Usuario {
	public $descricao;
	public $titulo;
	public $login;
	public $senha;	
    public $arquivo;
    public function Usuario() {
		$this->arquivo = new Arquivo();
    }
	
	public function cadastrar(){
		$this->login = strtolower(trim($this->login));
		if(!file_exists(Config::$dir.$this->login."/")){
			mkdir(Config::$dir.$this->login);
			chmod(Config::$dir.$this->login,0777);
			$this->infoXML();
			mkdir(Config::$dir.$this->login."/fotos");
			chmod(Config::$dir.$this->login."/fotos",0777);
			mkdir(Config::$dir.$this->login."/css");
			chmod(Config::$dir.$this->login."/css",0777);			
			$this->senha = base64_encode(serialize(strtolower(trim($this->senha))));
			$this->arquivo->nome      = sha1($this->login);
			$this->arquivo->diretorio = Config::$dir."/".$this->login."/";
			$this->arquivo->conteudo  = $this->senha;
			$this->arquivo->gerar();
			$foto  = new Foto();
			$video = new Video();
			$texto = new Texto();
			$texto->login = $foto->login = $video->login = $this->login;
			$texto->gerarXml();
			$foto->gerarXml();
			$video->gerarXml();
			$html = new GerarHtml();
			$html->dados['titulo']    = $this->titulo;
			$html->dados['conteudo']  = "";
			$html->dados['site']      = Config::$url;
			$this->arquivo->nome      = "index.html";
			$this->arquivo->diretorio = Config::$dir."/".$this->login."/";
			$this->arquivo->conteudo  = $html->index();
			$this->arquivo->gerar();
			$this->arquivo->nome      = "adm.php";
			$this->arquivo->diretorio = Config::$dir."/".$this->login."/";
			$this->arquivo->conteudo  = $html->admPHP();
			$this->arquivo->gerar();
			$this->gerarCSS();
			return true;
		}else{
			return false;
		}	
	}
	
	public function gerarCSS(){
		$html = new GerarHtml();
		if(file_exists(Config::$dir.strtolower(trim($this->login))."/css.xml")){
			$xml = simplexml_load_file(Config::$dir.strtolower(trim($this->login))."/css.xml");
			$html->dados['painel']    = $xml->painel;
			$html->dados['link']      = $xml->link;
			$html->dados['fundo']     = $xml->fundo;
			$html->dados['fonte']     = $xml->fonte;					
		}else{
			$html->dados['painel']    = "#ffffff";
			$html->dados['link']      = "#0000ff";
			$html->dados['fundo']     = "#000000";
			$html->dados['fonte']     = "#000000";					
			$xml = '<?xml version="1.0" encoding="UTF-8"?>' .
				'<corpo>' .
					'<painel><![CDATA['.$html->dados['painel'].']]></painel>'.
					'<link><![CDATA['.$html->dados['link'].']]></link>'.
					'<fundo><![CDATA['.$html->dados['fundo'].']]></fundo>'.
					'<fonte><![CDATA['.$html->dados['fonte'].']]></fonte>'.
				'</corpo>';
			$this->arquivo->nome      = "css.xml";
			$this->arquivo->diretorio = Config::$dir."/".$this->login."/";
			$this->arquivo->conteudo  = $xml;
			$this->arquivo->gerar();				
		}
		$this->arquivo->nome      = "template.css";
		$this->arquivo->diretorio = Config::$dir."/".$this->login."/css/";
		$this->arquivo->conteudo  = $html->css();
		$this->arquivo->gerar();				
	}
	
	public function gerarIndex(){
		if(file_exists(Config::$dir.strtolower(trim($this->login))."/info.xml")){
			$xml = simplexml_load_file(Config::$dir.strtolower(trim($this->login))."/info.xml");
			$this->titulo = $xml->titulo;
		}else{
			$this->titulo = "";
		}
		$html         = new GerarHtml();
		$texto        = new Texto();
		$video        = new Video();
		$foto         = new Foto();
		$video->login = $this->login;
		$texto->login = $this->login;
		$foto->login = $this->login;
		$texto->carregar();
		$vetor = $texto->dados();
		if(count($vetor)>0){
			$html->dados['texto']     = $vetor[count($vetor)-1]['texto'];
			$html->dados['titulo']    = $vetor[count($vetor)-1]['titulo'];
			$html->dados['data']      = $vetor[count($vetor)-1]['data'];
			$texto                    = $html->textoIndex();			
		}else{
			$texto                    = "";						
		}
		$video->carregar();
		$vetor = $video->dados();
		if(count($vetor)>0){
			$html->dados['texto']     = $vetor[count($vetor)-1]['texto'];
			$html->dados['titulo']    = $vetor[count($vetor)-1]['titulo'];
			$html->dados['data']      = $vetor[count($vetor)-1]['data'];
			$html->dados['video']     = $vetor[count($vetor)-1]['url'];
			$html->dados['embed']     = $html->embedVideo();
			$video                    = $html->videoIndex();
		}else{
			$video                    = "";			
		}
		$foto->carregar();
		$vetor = $foto->dados();
		if(count($vetor)>0){
			$html->dados['texto']     = $vetor[count($vetor)-1]['texto'];
			$html->dados['titulo']    = $vetor[count($vetor)-1]['titulo'];
			$html->dados['data']      = $vetor[count($vetor)-1]['data'];
			$html->dados['foto']      = $vetor[count($vetor)-1]['url'];
			$html->dados['embed']     = $html->embedFoto();
			$foto                     =	$html->fotoIndex();	
		}else{
			$foto                     =	"";				
		}
		$html->dados['titulo']    = $this->titulo;
		$html->dados['conteudo']  = $foto.$video.$texto;
		$html->dados['site']      = Config::$url;
		$this->arquivo->nome      = "index.html";
		$this->arquivo->diretorio = Config::$dir."/".$this->login."/";
		$this->arquivo->conteudo  = $html->index();
		$this->arquivo->gerar();		
		$rss = new RSS();
		$rss->login = $this->login;
		$rss->gerarRSS();
	}

	public function infoXML(){
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' .
			'<corpo>' .
				'<titulo><![CDATA['.htmlentities($this->titulo).']]></titulo>'.
				'<login><![CDATA['.htmlentities($this->login).']]></login>'.
				'<descricao><![CDATA['.htmlentities($this->descricao).']]></descricao>'.
			'</corpo>';
		$this->arquivo->nome      = "info.xml";
		$this->arquivo->diretorio = Config::$dir."/".$this->login."/";
		$this->arquivo->conteudo  = $xml;
		$this->arquivo->gerar();				
	}	
	public function validarLogin(){
		if(file_exists(Config::$dir.strtolower(trim($this->login))."/".sha1(strtolower(trim($this->login))))){
			$this->arquivo->nome      = sha1(strtolower(trim($this->login)));
			$this->arquivo->diretorio = Config::$dir."/".strtolower(trim($this->login))."/";
			$senhaTemp = unserialize(base64_decode($this->arquivo->ler()));			 
			if($senhaTemp==strtolower(trim($this->senha))){
				return true;											
			}else{
				return false;							
			}
		}else{
			return false;
		}
	}
}
?>