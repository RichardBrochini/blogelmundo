<?php

class RSS {
	public $login;
    public function RSS() {
		$this->arquivo = new Arquivo();
    }
    public function gerarRSS(){
 		if(file_exists(Config::$dir.strtolower(trim($this->login))."/info.xml")){
			$xml = simplexml_load_file(Config::$dir.strtolower(trim($this->login))."/info.xml");
			$titulo    = $xml->titulo;
			$descricao = $xml->descricao;
		}else{
			$titulo = "";
		}
    	$xml ='<?xml version="1.0" encoding="iso-8859-1"?>' .
    			'<rss version="2.0">' .
    			'<channel>' .
	    			'<title><![CDATA['.$titulo.']]></title>' .
	    			'<link>'.Config::$url.$this->login.'</link>' .
	    			'<description><![CDATA['.$descricao.']]></description>' .
	    			'<language>pt-br</language>';
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
		$xml=$xml.'<item>'. 
			'<title><![CDATA['.$vetor[count($vetor)-1]['titulo'].']]></title>'.
			'<link>'.Config::$url.$this->login.'</link>'. 
			'<description><![CDATA['.$vetor[count($vetor)-1]['texto'].']]></description>'.
			'<pubDate>'.$vetor[count($vetor)-1]['data'].'</pubDate>'.
		'</item>';	
		}
		$video->carregar();
		$vetor = $video->dados();
		if(count($vetor)>0){
			$xml=$xml.'<item>'. 
				'<title><![CDATA['.$vetor[count($vetor)-1]['titulo'].']]></title>'.
				'<link>'.Config::$url.$this->login.'</link>'. 
				'<description><![CDATA['.$vetor[count($vetor)-1]['texto'].']]></description>'.
				'<pubDate>'.$vetor[count($vetor)-1]['data'].'</pubDate>'.
			'</item>';	
		}
		$foto->carregar();
		$vetor = $foto->dados();
		if(count($vetor)>0){
			$html->dados['foto']      = $vetor[count($vetor)-1]['url'];
			$xml=$xml.'<item>'. 
				'<title><![CDATA['.$vetor[count($vetor)-1]['titulo'].']]></title>'.
				'<link>'.Config::$url.$this->login.'</link>'. 
				'<description><![CDATA['.$html->embedFoto().'<br/>'.$vetor[count($vetor)-1]['texto'].']]></description>'.
				'<pubDate>'.$vetor[count($vetor)-1]['data'].'</pubDate>'.
			'</item>';	
		}
    			$xml=$xml.'</channel>' .
    			'</rss>';
    	$this->arquivo->nome      = "rss.xml";
		$this->arquivo->diretorio = Config::$dir."/".$this->login."/";
		$this->arquivo->conteudo  = $xml;
		$this->arquivo->gerar();				
    }
}












