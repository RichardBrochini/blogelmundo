<?php

class Video {
	private $arquivo;
	private $videos;
	private $contador;
	public $login;  
    public function Video(){
		$this->arquivo = new Arquivo();
    	$this->contador = 0;
    }
    public function dados(){
    	return 	$this->videos;
    }
    public function pegarId(){
    	return $this->contador;
    }
	public function carregar(){
		if(file_exists(Config::$dir.strtolower(trim($this->login))."/video.xml")){
			$xml = simplexml_load_file(Config::$dir.strtolower(trim($this->login))."/video.xml");
			foreach ($xml->video as $video) {
				if(isset($video->titulo) && isset($video->texto)){
				   $this->videos[$this->contador] = array(
				   		'id'=>$video->id,
				   		'data'=>$video->data,
				   		'url'=>$video->url,
						'titulo'=>$video->titulo,
				   		'texto'=>$video->texto
				   );
				   $this->contador++;						
				}
			}			
		}else{
			$this->videos=null;
		}	
	}
	public function adicionarElemento($vetor){
	   if(is_array($vetor)){
		   $this->videos[$this->contador] = array(
		   		'id'=>$vetor['id'],
		   		'data'=>$vetor['data'],
		   		'titulo'=>$vetor['titulo'],
		   		'texto'=>$vetor['texto'],
		   		'url'=>$vetor['video']
		   );
		   $this->contador++;									   	
	   }
	}
	public function excluir($id){
		$this->carregar();
		$tempVetor = null;
		$j=0;
		$x=0;
		while($this->videos[$x]){
			if($id!=$this->videos[$x]['id']){
				$tempVetor[$j]['id']     = $j;
				$tempVetor[$j]['titulo'] = $this->videos[$x]['titulo'];
				$tempVetor[$j]['data']   = $this->videos[$x]['data'];
				$tempVetor[$j]['texto']  = $this->videos[$x]['texto'];
				$tempVetor[$j]['url']  = $this->videos[$x]['url'];
				$j++;	
			}
			$x++;	
		}
		$this->videos = $tempVetor;
		$this->contador = $j;
		$this->gerarXml();    	
    }
	public function gerarXml(){
		if($this->videos==null){
			$xml = '<?xml version="1.0" encoding="UTF-8"?>' .
				'<corpo>' .
					'<video></video>'.
				'</corpo>';
		}elseif(is_array($this->videos)){
			$x=0;
			$xml = '<?xml version="1.0" encoding="UTF-8"?><corpo>';
			while($this->videos[$x]){
				$this->videos[$x]['url'] = str_replace("http://br.youtube.com/watch?v=","",$this->videos[$x]['url']);
				$this->videos[$x]['url'] = str_replace("http://www.youtube.com/watch?v=","",$this->videos[$x]['url']);
				$xml=$xml.'<video>' .
							'<id>'.$this->videos[$x]['id'].'</id>'.
							'<data><![CDATA['.$this->videos[$x]['data'].']]></data>'.
							'<titulo><![CDATA['.$this->videos[$x]['titulo'].']]></titulo>'.
							'<texto><![CDATA['.$this->videos[$x]['texto'].']]></texto>'.							
							'<url><![CDATA['.$this->videos[$x]['url'].']]></url>'.							
						'</video>';
				$x++;
			}
			$xml=$xml.'</corpo>';			
		}
		$this->arquivo->nome      = "video.xml";
		$this->arquivo->diretorio = Config::$dir.strtolower(trim($this->login))."/";
		$this->arquivo->conteudo  = $xml;
		$this->arquivo->gerar();
		$this->gerarPagina();
	}
	private function gerarPagina(){
		$html  = new GerarHtml();
		if(file_exists(Config::$dir.strtolower(trim($this->login))."/info.xml")){
			$xml = simplexml_load_file(Config::$dir.strtolower(trim($this->login))."/info.xml");
			$html->dados['titulo'] = $xml->titulo;
		}else{
			$html->dados['titulo'] = "";
		}		
		$texto = "";
		$x=0;
		while($this->videos[$x]){
			$html->dados['video'] = $this->videos[$x]['url'];
			$texto = $texto."<div>".$this->videos[$x]['titulo']."<br/>" .
								$html->embedVideo().
								"<br/>".$this->videos[$x]['texto']."<br/>
								<br/>
								<i>postado dia:</i>".$this->videos[$x]['data']."
							</div>";
			$x++;
		}
		$html->dados['conteudo']  = $texto;
		$html->dados['site']      = Config::$url;		
		$this->arquivo->nome      = "video.html";
		$this->arquivo->diretorio = Config::$dir.strtolower(trim($this->login))."/";
		$this->arquivo->conteudo  = $html->index();
		$this->arquivo->gerar();		
	}
}
?>